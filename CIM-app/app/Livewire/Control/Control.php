<?php

namespace App\Livewire\Control;

use App\Models\clasemantenimiento;
use App\Models\detallelaboratorio;
use App\Models\detallemantenimiento;
use App\Models\equipo;
use App\Models\laboratorio;
use App\Models\mantenimiento;
use App\Models\periferico;
use App\Models\tipomantenimiento;
use App\Models\usuario;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Control extends Component
{

    use WithPagination;

    public $incSoft = [];
    public $incHard = [];
    public $incSel = [];       // checked items: [IdInc => true]
    public $incBloq = [];      // disabled items: [IdInc => true] o ["{IdInc}_{IdPef}" => true]
    public $incStatus = [];    // estado por par: ["{IdInc}_{IdPef}" => EstadoIpf]
    public $incStatusByInc = []; // estado por incidencia: [IdInc => EstadoIpf]
    public $showIncModal = false;
    public $idTpm, $idInc;
    public $idClm;
    public $idMan = [];
    public $idLab = '';
    public $busquedaEquipo = '';
    public $equipos = [];
    public $mantsoft = [];
    public $manthard = [];
    public $mantenimientosFiltrados = [];
    public $mantenimientoRealizado = false;
    public $idEqo = '';
    public $observacionDtl, $realizadoDtl, $verificadoDtl, $fechaDtl, $estadoDtl;
    public $modalTitle = '';
    public $modalMessage = '';
    public $modalIcon = 'bi bi-info-circle-fill text-info';
    #[Url('Busqueda')]
    public $query = '';

    public function selectInfo($id)
    {
        $this->idLab = $id;
    }
    public function limpiar()
    {
        $this->reset(['query', 'idLab', 'idEqo', 'idTpm', 'mantsoft', 'manthard', 'idMan', 'mantenimientosFiltrados', 'equipos']);
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function rules(): array
    {
        $rules = [
            'idLab' => ['required'],
            'idEqo' => ['required'],
            'idTpm' => ['required'],
        ];

        if ($this->idLab && $this->idEqo && $this->idTpm) {
            $rules['idMan'] = ['required', 'array', 'min:1'];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'idLab.required' => 'Seleccione un laboratorio.',
            'idEqo.required' => 'Seleccione un equipo.',
            'idTpm.required' => 'Seleccione un tipo de mantenimiento.',
            'idMan.required' => 'Seleccione al menos una tarea de mantenimiento.',
            'idMan.array' => 'Selección de tareas inválida.',
            'idMan.min' => 'Seleccione al menos una tarea de mantenimiento.',
        ];
    }
    public function updated($property)
    {
        if (in_array($property, ['idLab', 'idEqo', 'idTpm'])) {
            $this->resetErrorBag('idMan');
        }

        $this->validateOnly($property, $this->rules());
    }

    public function getPuedeRegistrarProperty(): bool
    {
        $validator = Validator::make(
            [
                'idLab' => $this->idLab,
                'idEqo' => $this->idEqo,
                'idTpm' => $this->idTpm,
                'idMan' => $this->idMan,
            ],
            $this->rules(),
            $this->messages()
        );

        return $validator->passes();
    }

    public function updatedIdLab()
    {
        $this->reset('equipos');
        $this->equipos = equipo::where('IdLab', $this->idLab)
            ->orderByRaw('CAST(SUBSTRING(NombreEqo,4)AS UNSIGNED)ASC')
            ->get();
    }

    public function updatedIdEqo()
    {

        $this->idMan = ((int)$this->idTpm === 2)
            ? []                                   // Correctivo: vacíos
            : $this->obtenerIdsMantenimientosHoy(); // Preventivo: lo de hoy
    }

    public function updatedQuery()
    {

        if (preg_match('/^[0-9]{8,20}$/', trim($this->query ?? ''))) {
            $this->onCodeDetected($this->query);
        }
    }

    public function updatedIdTpm()
    {
        if ((int)$this->idTpm === 2) {
            $this->idMan = [];
        } else {
            $this->idMan = $this->obtenerIdsMantenimientosHoy();
        }

        if ($this->idTpm && $this->idClm) {
            $this->mantenimientosFiltrados  = mantenimiento::where('IdTpm', $this->idTpm)
                ->where('IdClm', $this->idClm)
                ->get();
        }
    }

    public function obtenerIdsMantenimientosHoy()
    {
        if ($this->idEqo) {
            return detallemantenimiento::where('IdEqo', $this->idEqo)
                ->whereDate('FechaDtm', now()->toDateString())
                ->pluck('IdMan')
                ->toArray();
        }
        return [];
    }

    public function actualizarSeleccion($idMantenimiento, $checked)
    {

        if ($checked) {
            if (!in_array($idMantenimiento, $this->idMan)) {
                $this->idMan[] = $idMantenimiento;
            }
        } else {
            $this->idMan = array_filter($this->idMan, function ($id) use ($idMantenimiento) {
                return $id != $idMantenimiento;
            });
        }
        $this->validateOnly('idMan', $this->rules());
    }

    #[On('scanner:code-detected')]
    public function onCodeDetected(string $code)
    {
        
        $this->query = trim($code);
        $this->resetPage();

        // Busca el equipo por su Código de Inventario
        $item = periferico::with('tipoperiferico')
            ->where('CodigoInventarioPef', $this->query)
            ->first();

        if ($item) {
            // ✅ sincroniza los selects
            $this->idLab  =  $item->equipo->IdLab;
            $this->equipos = equipo::get();
            $this->idEqo  =  $item->IdEqo;

            // Mensaje de confirmación
            $this->modalTitle   = 'Equipo encontrado';
            $this->modalMessage = sprintf(
                '%s • %s • %s',
                $item->CodigoInventarioPef,
                $item->tipoperiferico->NombreTpf ?? '—',
                $item->EstadoPef ? 'Activo' : 'Inactivo'
            );
            $this->modalIcon    = 'bi bi-check-circle-fill text-success';

            $this->idMan = ((int)$this->idTpm === 2)
                ? []
                : $this->obtenerIdsMantenimientosHoy();


            // Abre el modal de confirmación (usa tu util existente)
            $this->dispatch('modal-open', payload: [
                'title'     => $this->modalTitle,
                'message'   => $this->modalMessage,
                'variant'   => 'success',
                'autoclose' => 2200, // cierra solo
            ]);
        } else {
            // Limpia filtros si no se halló
            $this->idLab = null;
            $this->idEqo = null;

            $this->modalTitle   = 'Sin coincidencias';
            $this->modalMessage = 'No existe un periférico con ese código.';
            $this->modalIcon    = 'bi bi-exclamation-triangle-fill text-warning';

            $this->dispatch('modal-open', payload: [
                'title'     => $this->modalTitle,
                'message'   => $this->modalMessage,
                'variant'   => 'warning',
                'autoclose' => 2500,
            ]);
        }
    }


    public function realizarmantenimiento()
    {
        $this->validate();

        if (!$this->idEqo) {
            $this->modalTitle = 'Falta seleccionar equipo';
            $this->modalMessage = 'Selecciona un equipo antes de realizar el mantenimiento.';
            $this->modalIcon = 'bi bi-exclamation-triangle-fill text-warning';
            $this->dispatch('modal-open');
            return;
        }

        try {
            $registradosHoy = detallemantenimiento::where('IdEqo', $this->idEqo)
                ->whereDate('FechaDtm', now()->toDateString())
                ->pluck('IdMan')
                ->toArray();

            $nuevos       = array_diff($this->idMan, $registradosHoy);
            $desmarcados  = array_diff($registradosHoy, $this->idMan);
            if ((int)$this->idTpm !== 2) {
                if (empty($nuevos) && empty($desmarcados)) {
                    $this->modalTitle   = 'Sin cambios';
                    $this->modalMessage = 'Realice alguna cambio para guardar.';
                    $this->modalIcon    = 'bi bi-exclamation-triangle-fill text-warning';
                    $this->dispatch('modal-open');
                    return;
                }
            }


            // Inserta los nuevos de hoy

            foreach ($nuevos as $id) {
                detallemantenimiento::create([
                    'IdMan'    => $id,
                    'IdEqo'    => $this->idEqo,
                    'FechaDtm' => now(),
                    'EstadoDtm' => true,
                ]);
            }

            // Borra los que desmarcaste hoy
            foreach ($desmarcados as $id) {
                detallemantenimiento::where('IdEqo', $this->idEqo)
                    ->where('IdMan', $id)
                    ->whereDate('FechaDtm', now()->toDateString())
                    ->delete();
            }

            // Sólo para CORRECTIVO (IdTpm = 2): cierra incidencias abiertas relacionadas
            $cerradas = 0;

            if ((int)$this->idTpm === 2) {
                // Cerrar incidencias para las tareas correctivas seleccionadas,
                // hayan sido o no "nuevos" hoy
                $idsParaCerrar = mantenimiento::whereIn('IdMan', $this->idMan)
                    ->where('IdTpm', 2)
                    ->pluck('IdMan')
                    ->all();

                if (!empty($idsParaCerrar)) {
                    DB::beginTransaction();
                    try {
                        $cerradas = $this->cerrarIncidenciasAbiertasPorMantenimientos((int)$this->idEqo, $idsParaCerrar);
                        DB::commit();
                    } catch (\Throwable $e) {
                        DB::rollBack();
                        Log::error('Error al cerrar incidencias tras mantenimiento', ['mensaje' => $e->getMessage()]);
                    }
                }
            } else {
                // NO-correctivo = como ya lo tienes: solo si hay "nuevos"
                if (!empty($nuevos)) {
                    $idsManCorrectivos = mantenimiento::whereIn('IdMan', $nuevos)
                        ->where('IdTpm', 2)
                        ->pluck('IdMan')
                        ->all();
                    if (!empty($idsManCorrectivos)) {
                        DB::beginTransaction();
                        try {
                            $cerradas = $this->cerrarIncidenciasAbiertasPorMantenimientos((int)$this->idEqo, $idsManCorrectivos);
                            DB::commit();
                        } catch (\Throwable $e) {
                            DB::rollBack();
                            Log::error('Error al cerrar incidencias tras mantenimiento', ['mensaje' => $e->getMessage()]);
                        }
                    }
                }
            }


            // Garantiza registro en detallelaboratorio (lo tuyo tal cual)
            $exdtl = detallelaboratorio::where('IdLab', $this->idLab)
                ->whereDate('FechaDtl', now()->toDateString())
                ->first();

            if (!$exdtl) {
                $usuarioActual = Auth::user();
                $nombreRealizador = $usuarioActual
                    ? trim(($usuarioActual->persona->NombrePer ?? '') . ' ' . ($usuarioActual->persona->ApellidoPaternoPer ?? ''))
                    : ($usuarioActual->UsernameUsa ?? 'SinUsuario');

                $tecnico = usuario::with('persona')->where('IdRol', 2)->first();
                $nombreTecnico = $tecnico
                    ? trim(($tecnico->persona->NombrePer ?? '') . ' ' . ($tecnico->persona->ApellidoPaternoPer ?? ''))
                    : 'SinUsuario';

                detallelaboratorio::create([
                    'IdLab'           => $this->idLab,
                    'RealizadoDtl'    => $nombreRealizador,
                    'IdTpm'           => $this->idTpm,
                    'FechaDtl'        => now(),
                    'EstadoDtl'       => 1,
                ]);
            }

            // Reset de UI
            $this->reset('idEqo', 'idTpm', 'idClm', 'idMan', 'idLab', 'query');
            $this->mantenimientosFiltrados = [];
            $this->mantsoft = [];
            $this->manthard = [];
            $this->mantenimientoRealizado = true;

            $this->modalTitle = '¡Éxito!';
            $extra = ((int)$this->idTpm === 2) ? " Incidencias cerradas: {$cerradas}." : '';
            $this->modalMessage = 'Mantenimiento registrado correctamente.' . $extra;
            $this->modalIcon = 'bi bi-check-circle-fill text-success';
            $this->dispatch('modal-open');
        } catch (\Throwable $e) {
            Log::error('Error al realizar mantenimiento', ['mensaje' => $e->getMessage()]);
            $this->modalTitle = 'Error';
            $this->modalMessage = 'Ocurrió un problema. Intenta más tarde.';
            $this->modalIcon = 'bi bi-x-circle-fill text-danger';
            $this->dispatch('modal-open');
        }
    }


    public function toggleIncidencia($idInc, $second = null, $third = null)
    {
        // Caso 1: solo se llamó con el id -> toggle server-side
        if (is_null($second) && is_null($third)) {
            if (isset($this->incSel[$idInc])) {
                unset($this->incSel[$idInc]);
            } else {
                $this->incSel[$idInc] = true;
            }
            return;
        }

        // Detectamos si el segundo parámetro es idPef (numérico) o el checked
        $idPef = null;
        $checked = null;

        if (is_numeric($second)) {
            $idPef = $second;
            $checked = $third;
        } else {
            $checked = $second;
        }

        // Si no viene checked (null), actuamos como toggle server-side
        if (is_null($checked)) {
            if (isset($this->incSel[$idInc])) {
                unset($this->incSel[$idInc]);
            } else {
                $this->incSel[$idInc] = true;
            }
            return;
        }

        // Normalizar a booleano (acepta "true"/"false"/1/0)
        $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);

        // Ya no comprobamos incBloq aquí. Si necesitas bloqueos, vuelve a añadir la lógica.
        if ($checked) {
            $this->incSel[$idInc] = true;
        } else {
            unset($this->incSel[$idInc]);
        }
    }

    public function seleccionarTodos($checked)
    {
        if ($checked) {
            $this->idMan = collect([$this->mantsoft, $this->manthard])
                ->flatten(1)
                ->map(function ($item) {
                    if (is_array($item) && isset($item['IdMan'])) return (int) $item['IdMan'];
                    if (is_object($item) && isset($item->IdMan)) return (int) $item->IdMan;
                    return (int) $item;
                })
                ->toArray();
        } else {
            // limpiar selección
            $this->idMan = [];
        }
    }


    public function render()
    {
        $this->mantenimientoRealizado = detallelaboratorio::where('IdLab', $this->idLab)
            ->whereDate('FechaDtl', now()->toDateString())
            ->exists();

        if (!empty($this->idTpm)) {
            // Caso: tipo de mantenimiento seleccionado
            // No hay tipo de mantenimiento seleccionado: colecciones vacías
            $this->mantsoft = mantenimiento::where('IdTpm', $this->idTpm)->Where('IdClm', 1)->get();
            $this->manthard = mantenimiento::where('IdTpm', $this->idTpm)->Where('IdClm', 2)->get();;
        }


        $laboratorios = laboratorio::get();
        if ($this->idLab) {
            $this->equipos = equipo::where('IdLab', $this->idLab)
                ->orderByRaw('CAST(SUBSTRING(NombreEqo,4)AS UNSIGNED)ASC')
                ->get();
        } else {
            $this->equipos = equipo::get();
        }
        $tipoman = tipomantenimiento::get();
        $claseman = clasemantenimiento::get();

        $usuarios = usuario::with(['persona', 'rol'])->where('IdRol', 2)->get();

        return view('livewire.Control.Control', [
            'laboratorios' => $laboratorios,

            'equipos' => $this->equipos,
            'tipoman' => $tipoman,
            'claseman' => $claseman,
            'mansoft' => $this->mantsoft,
            'manhard' => $this->manthard,
            'usuarios' => $usuarios,
        ]);
    }
}
