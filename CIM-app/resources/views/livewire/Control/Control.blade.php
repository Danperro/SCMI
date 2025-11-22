<div class="container-xxl py-3">
    <!-- Header -->

    <div class="card mb-3">
        <div class="card-body">
            <h2 class="h3 mb-0 text-center">
                Registrar mantenimientos preventivos a equipos
            </h2>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-lg-3">
                    <label for="query" class="form-label fw-semibold">Código del periferico o equipo</label>
                    <div class="input-group has-validation">
                        <input id="query" type="text" class="form-control @error('query') is-invalid @enderror"
                            placeholder="Ej: 740895005083" wire:model.live="query" aria-describedby="codigoFeedback"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'')">

                        <button id="btnScan" type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#scannerModal">
                            <i class="bi bi-upc-scan"></i>
                        </button>

                        <div id="codigoFeedback" class="invalid-feedback">
                            @error('query')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <label for="idLab" class="form-label fw-semibold">Seleccionar laboratorio</label>
                    <select id="idLab" class="form-select" wire:model.live="idLab">
                        <option value="" hidden>Selecciona un laboratorio</option>
                        @foreach ($laboratorios as $lab)
                            <option value="{{ $lab->IdLab }}">{{ $lab->NombreLab }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-2">
                    <label for="idEqo" class="form-label fw-semibold">Seleccionar equipo</label>
                    <select id="idEqo" class="form-select" wire:model.live="idEqo">
                        <option value="" hidden>Seleccionar</option>
                        @foreach ($equipos as $eqo)
                            <option value="{{ $eqo->IdEqo }}">{{ $eqo->NombreEqo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-2">
                    <label for="idTpm" class="form-label fw-semibold">Tipo</label>
                    <select id="idTpm" class="form-select" wire:model.live="idTpm" @disabled(@empty($idEqo))>
                        <option value="" hidden>Tipo</option>
                        @foreach ($tipoman as $tip)
                            <option value="{{ $tip->IdTpm }}">{{ $tip->NombreTpm }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-2 d-grid">
                    <button class="btn btn-outline-secondary" type="button" wire:click="limpiar">
                        <i class="bi bi-eraser me-1"></i> Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- Mantenimientos -->
            <form class="position-relative" wire:submit.prevent="realizarmantenimiento">
                <div class="row g-3 align-items-center mb-3">
                    <!-- título a la izquierda -->
                    <div class="col-6 col-lg-4">
                        <h2 class="h5 fw-semibold mb-0">Tareas de mantenimiento</h2>
                    </div>

                    <!-- checkbox a la derecha -->
                    <div class="col-6 col-lg-8 text-end">
                        <label class="fw-semibold me-2" for="chk-soft">Seleccionar todos</label>
                        <input id="chk-all" type="checkbox" wire:click="seleccionarTodos($event.target.checked)"
                            @checked(count($idMan) === collect($mansoft)->count() + collect($manhard)->count())>

                    </div>
                </div>


                <div class="row g-3">
                    <!-- Software -->
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive table-scroll">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light position-sticky top-0">
                                            <tr>
                                                <th class="w-100">Mantenimiento para Software</th>
                                                <th class="text-center" style="width:120px">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mansoft as $man)
                                                <tr>
                                                    <td class="py-2 px-3">{{ $man->NombreMan }}</td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="form-check-input"
                                                            wire:click="actualizarSeleccion({{ $man->IdMan }}, $event.target.checked)"
                                                            @checked(in_array($man->IdMan, $idMan))>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hardware -->
                    <div class="col-12 col-lg-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive table-scroll">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light position-sticky top-0">
                                            <tr>
                                                <th class="w-100">Mantenimiento para Hardware</th>
                                                <th class="text-center" style="width:120px">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($manhard as $man)
                                                <tr>
                                                    <td class="py-2 px-3">{{ $man->NombreMan }}</td>
                                                    <td class="text-center">
                                                        <input type="checkbox" class="form-check-input"
                                                            wire:click="actualizarSeleccion({{ $man->IdMan }}, $event.target.checked)"
                                                            @checked(in_array($man->IdMan, $idMan))>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de acciones -->
                <div class="action-bar mt-3 d-flex justify-content-end gap-2">
                    <button class="btn fw-bold {{ $this->puedeRegistrar ? 'btn-success' : 'btn-outline-secondary' }}"
                        type="submit" @if (!$this->puedeRegistrar) disabled @endif
                        title="{{ $this->puedeRegistrar ? 'Listo para registrar' : 'Seleccione laboratorio, equipo, tipo y al menos una tarea' }}">
                        <i class="bi bi-gear me-1"></i> Registrar mantenimiento
                    </button>

                </div>
            </form>
        </div>
    </div>


    <!-- Modal: mensaje de confirmación -->
    <div class="modal fade" id="appModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i id="appModalIcon" class="{{ $modalIcon }}" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-2">{{ $modalTitle }}</h4>
                    <p class="text-muted mb-0">{{ $modalMessage }}</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal: Escáner de código de barras -->
    <div class="modal fade" id="scannerModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-upc-scan me-2"></i>Escanear código</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>

                <div class="modal-body p-3">
                    <!-- Vista de cámara del tamaño del rectángulo -->
                    <div class="d-flex justify-content-center align-items-center bg-dark rounded"
                        style="height:60vh;">
                        <div id="scannerViewport" class="position-relative"
                            style="width:70%; height:60%; border:3px solid #28a745; border-radius:12px; overflow:hidden;">
                            <video id="scannerVideo" playsinline muted></video>
                            <canvas id="scannerCanvas"></canvas>
                        </div>
                    </div>

                    <div id="scannerStatus" class="small text-muted mt-2">
                        Concede permiso a la cámara y apunta al código. Procura buena luz. Yo hago el resto.
                    </div>

                    <!-- Fallback manual -->
                    <div class="input-group mt-3">
                        <input id="manualBarcode" type="text" class="form-control"
                            placeholder="Ingresar código manualmente">
                        <button id="useManualBarcode" class="btn btn-outline-secondary" type="button">
                            Usar
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="switchCamera" class="btn btn-outline-primary" type="button">
                        <i class="bi bi-camera-reverse me-1"></i> Cambiar cámara
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    (() => {
        let stream = null;
        let usingBack = true;
        let detector = null;
        let detectLoopId = null;
        let alreadyHandled = false; // <— guardia anti-repetidos

        const video = document.getElementById('scannerVideo');
        const canvas = document.getElementById('scannerCanvas');
        const status = document.getElementById('scannerStatus');
        const btnUse = document.getElementById('useManualBarcode');
        const txtMan = document.getElementById('manualBarcode');
        const btnFlip = document.getElementById('switchCamera');

        const supportedFormats = [
            'code_128', 'code_39', 'code_93', 'ean_13', 'ean_8', 'upc_a', 'upc_e', 'itf', 'codabar',
            'data_matrix', 'qr_code'
        ];

        function setQueryValue(code) {
            const input = document.getElementById('query');
            if (input) {
                input.value = code;
                input.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        }

        function showToast(variant, title, message) {
            // dispara un SOLO evento; tus manejadores deben existir una sola vez
            const event = new CustomEvent('modal-open', {
                detail: {
                    payload: {
                        variant,
                        title,
                        message,
                        autoclose: 2000
                    }
                }
            });
            window.dispatchEvent(event);
        }

        async function ensureDetector() {
            if (!('BarcodeDetector' in window)) {
                console.warn("BarcodeDetector no soportado. Usando jsQR como alternativa.");
                // Si BarcodeDetector no está disponible, usar jsQR
                return false; // Indicamos que vamos a usar jsQR
            }
            if (!detector) {
                try {
                    detector = new window.BarcodeDetector({
                        formats: supportedFormats
                    });
                } catch {
                    detector = new window.BarcodeDetector();
                }
            }
            return detector;
        }


        async function startCamera() {
            stopCamera();
            alreadyHandled = false; // <— reset del guard
            status.textContent = 'Abriendo cámara...';
            const constraints = {
                audio: false,
                video: {
                    facingMode: usingBack ? {
                        ideal: 'environment'
                    } : 'user',
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                }
            };
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = stream;
            await video.play();
            status.textContent = 'Apunta el código dentro del marco.';
            startDetectLoop();
        }

        function stopCamera() {
            if (detectLoopId) {
                cancelAnimationFrame(detectLoopId);
                detectLoopId = null;
            }
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
            if (video) {
                video.pause();
                video.srcObject = null;
            }
        }

        function startDetectLoop() {
            const ctx = canvas.getContext('2d', {
                willReadFrequently: true
            });

            const step = async () => {
                try {
                    if (video.readyState >= 2 && !alreadyHandled) {
                        // Ajustar el tamaño del canvas
                        canvas.width = video.videoWidth || canvas.clientWidth || 1280;
                        canvas.height = video.videoHeight || canvas.clientHeight || 720;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        const bitmap = await createImageBitmap(canvas);

                        // Usamos el detector adecuado según la disponibilidad
                        const detectorUsed = await ensureDetector();

                        if (detectorUsed) {
                            // Si BarcodeDetector está disponible, usarlo
                            const codes = await detectorUsed.detect(bitmap);
                            if (codes && codes.length) {
                                const raw = (codes[0].rawValue || '').trim();
                                if (raw && !alreadyHandled) {
                                    alreadyHandled = true; // Corta repetidos
                                    handleCode(raw);
                                    return;
                                }
                            }
                        } else {
                            // Si BarcodeDetector no está disponible, usar jsQR
                            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                            const code = jsQR(imageData.data, canvas.width, canvas.height);
                            if (code) {
                                if (!alreadyHandled) {
                                    alreadyHandled = true; // Corta repetidos
                                    handleCode(code.data); // Usamos `code.data` en lugar de `raw`
                                    return;
                                }
                            }
                        }
                    }
                } catch (err) {
                    console.error(err);
                    status.textContent =
                        'No pude leer nada. Acerca más, mejora la luz o usa el campo manual.';
                }
                detectLoopId = requestAnimationFrame(step);
            };
            detectLoopId = requestAnimationFrame(step);
        }


        function handleCode(code) {
            stopCamera();

            // Cierra el modal del escáner antes de cualquier otro
            const modalEl = document.getElementById('scannerModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            // Pasa el valor al input y dispara Livewire
            setQueryValue(code);
            try {
                const root = document.querySelector('[wire\\:id]');
                const compId = root?.getAttribute('wire:id');
                if (compId && window.Livewire?.find) {
                    window.Livewire.find(compId).call('selectByBarcode', code);
                }
            } catch (e) {
                console.error('No pude invocar Livewire:', e);
            }

            // Luego el modal de confirmación
            showToast('success', 'Código detectado', `Leído: ${code}`);
        }
        window.handleCode = handleCode;

        btnUse?.addEventListener('click', () => {
            const code = (txtMan?.value || '').trim();
            if (!code) return;
            alreadyHandled = true;
            handleCode(code);
        });

        btnFlip?.addEventListener('click', async () => {
            usingBack = !usingBack;
            try {
                await startCamera();
            } catch {
                status.textContent = 'No pude cambiar de cámara.';
            }
        });

        document.getElementById('scannerModal')?.addEventListener('shown.bs.modal', async () => {
            try {
                await ensureDetector();
                await startCamera();
            } catch (e) {
                console.error(e);
                status.innerHTML =
                    'Tu navegador no soporta escaneo nativo. Usa el campo manual o un navegador compatible.';
            }
        });
        document.getElementById('scannerModal')?.addEventListener('hidden.bs.modal', () => {
            stopCamera();
        });

        /* Evita registrar doble “showAppModal” si ya lo hiciste en otro script */
        if (!window.__appModalInit) {
            window.__appModalInit = true;
            // aquí puedes dejar tu único bloque que escucha 'modal-open'
            window.addEventListener('modal-open', (e) => {
                const d = e?.detail?.payload ?? e?.detail ?? {};
                // showAppModal(d);  // usa tu implementación ya existente
            });
        }
    })();
</script>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const iconMap = {
            success: 'bi-check-circle-fill text-success',
            warning: 'bi-exclamation-triangle-fill text-warning',
            danger: 'bi-x-circle-fill text-danger',
            info: 'bi-info-circle-fill text-info'
        };

        function showAppModal(d) {
            console.log('Mostrando modal con datos:', d); // Debug

            if (!d || typeof d !== 'object') d = {};
            const title = d.title ?? 'Aviso';
            const message = d.message ?? '';
            const variant = d.variant ?? 'info';
            const autoclose = Number(d.autoclose ?? 2000);

            // Los IDs ahora coinciden con el HTML
            const iconEl = document.getElementById('appModalIcon');
            const titleEl = document.getElementById('appModalTitle');
            const msgEl = document.getElementById('appModalMessage');

            if (iconEl) {
                iconEl.className = `bi ${iconMap[variant] || iconMap.info}`;
                iconEl.style.fontSize = '4rem';
            }
            if (titleEl) titleEl.textContent = title;
            if (msgEl) msgEl.textContent = message;

            const modalEl = document.getElementById('appModal');
            if (!modalEl) {
                console.error('Modal #appModal no encontrado');
                return;
            }

            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();

            if (!Number.isNaN(autoclose) && autoclose > 0) {
                setTimeout(() => modal.hide(), autoclose);
            }
        }

        // Escucha eventos de Livewire
        document.addEventListener('livewire:init', () => {
            console.log('Livewire inicializado'); // Debug

            if (window.Livewire && typeof Livewire.on === 'function') {
                Livewire.on('modal-open', (event) => {
                    console.log('Evento modal-open recibido:', event); // Debug

                    // En Livewire v3, el evento viene directamente o dentro de payload
                    const data = event.payload || event;
                    showAppModal(data);
                });
            }
        });

        // Fallback para eventos del window
        window.addEventListener('modal-open', (e) => {
            console.log('Evento window modal-open:', e.detail); // Debug

            const detail = e.detail;
            const d = detail && detail.payload ? detail.payload : detail;
            showAppModal(d);
        });

        // Test manual (puedes eliminar esto después)
        window.testModal = function() {
            showAppModal({
                title: 'Test Modal',
                message: 'Este es un mensaje de prueba',
                variant: 'success',
                autoclose: 3000
            });
        };
    });
</script>
<!-- Utilidades de modales -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const iconMap = {
            success: 'bi-check-circle-fill text-success',
            warning: 'bi-exclamation-triangle-fill text-warning',
            danger: 'bi-x-circle-fill text-danger',
            info: 'bi-info-circle-fill text-info'
        };

        let lastActiveElement = null;

        function getModalInstance(el) {
            return bootstrap.Modal.getOrCreateInstance(el, {
                backdrop: 'static',
                keyboard: true
            });
        }

        function blurInside(el) {
            const active = document.activeElement;
            if (active && el.contains(active)) {
                try {
                    active.blur();
                } catch {}
            }
            if (document.activeElement === el) {
                try {
                    el.blur();
                } catch {}
            }
        }

        function restoreFocus() {
            if (lastActiveElement && document.contains(lastActiveElement)) {
                try {
                    lastActiveElement.focus({
                        preventScroll: true
                    });
                } catch {}
            } else {
                try {
                    document.body.focus();
                } catch {}
            }
        }

        function cleanBackdrops() {
            document.querySelectorAll('.modal-backdrop.show').forEach(el => el.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }

        function showAppModal(d) {
            if (!d || typeof d !== 'object') d = {};
            const payload = {
                title: d.title ?? 'Aviso',
                message: d.message ?? '',
                variant: d.variant ?? 'info',
                autoclose: Number(d.autoclose ?? 2000)
            };

            const modalEl = document.getElementById('appModal');
            if (!modalEl) return;

            const iconEl = modalEl.querySelector('#appModalIcon');
            const titleEl = modalEl.querySelector('.modal-body h4') || modalEl.querySelector('h4');
            const msgEl = modalEl.querySelector('.modal-body p') || modalEl.querySelector('p');

            if (iconEl) iconEl.className = `bi ${iconMap[payload.variant] || iconMap.info}`;
            if (titleEl) titleEl.textContent = payload.title;
            if (msgEl) msgEl.textContent = payload.message;

            lastActiveElement = document.activeElement;
            const modal = getModalInstance(modalEl);
            if (!modalEl.classList.contains('show')) modal.show();

            if (!Number.isNaN(payload.autoclose) && payload.autoclose > 0) {
                setTimeout(() => {
                    try {
                        safeHide('appModal');
                    } catch {}
                }, payload.autoclose);
            }
        }

        function safeHide(id) {
            const el = document.getElementById(id);
            if (!el) return;
            blurInside(el);
            const modal = getModalInstance(el);
            modal.hide();
        }

        document.getElementById('appModal')?.addEventListener('hidden.bs.modal', () => {
            restoreFocus();
            cleanBackdrops();
        });

        document.addEventListener('livewire:init', () => {
            if (window.Livewire && typeof Livewire.on === 'function') {
                Livewire.on('modal-open', (event) => {
                    const data = event?.payload ?? event ?? {};
                    showAppModal(data);
                });
            }
        });

        window.addEventListener('modal-open', (e) => {
            const d = e?.detail?.payload ?? e?.detail ?? {};
            showAppModal(d);
        });

        window.addEventListener('cerrar-modal', (e) => {
            const id = e?.detail?.modalId;
            if (!id) return;
            safeHide(id);
        });
    });
</script>

<script>
    (() => {
        let stream = null;
        let usingBack = true;
        let detector = null;
        let detectLoopId = null;
        let alreadyHandled = false;

        const video = document.getElementById('scannerVideo');
        const canvas = document.getElementById('scannerCanvas');
        const status = document.getElementById('scannerStatus');
        const btnUse = document.getElementById('useManualBarcode');
        const txtMan = document.getElementById('manualBarcode');
        const btnFlip = document.getElementById('switchCamera');
        const supportedFormats = [
            'code_128', 'code_39', 'code_93', 'ean_13', 'ean_8',
            'upc_a', 'upc_e', 'itf', 'codabar', 'data_matrix', 'qr_code'
        ];

        // ------------- utilidades -------------
        function stopCamera() {
            if (detectLoopId) {
                cancelAnimationFrame(detectLoopId);
                detectLoopId = null;
            }
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
            if (video) {
                video.pause();
                video.srcObject = null;
            }
        }

        async function ensureDetector() {
            if (!('BarcodeDetector' in window)) {
                throw new Error('Este navegador no soporta BarcodeDetector.');
            }
            if (!detector) {
                try {
                    detector = new window.BarcodeDetector({
                        formats: supportedFormats
                    });
                } catch {
                    detector = new window.BarcodeDetector();
                }
            }
            return detector;
        }

        async function startCamera() {
            stopCamera();
            alreadyHandled = false;
            status.textContent = 'Abriendo cámara...';
            const constraints = {
                video: {
                    facingMode: usingBack ? {
                        ideal: 'environment'
                    } : 'user',
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                }
            };
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = stream;
            await video.play();
            status.textContent = 'Apunta el código dentro del marco.';
            startDetectLoop();
        }

        // ------------- detección -------------
        function startDetectLoop() {
            const ctx = canvas.getContext('2d', {
                willReadFrequently: true
            });
            const step = async () => {
                try {
                    if (video.readyState >= 2 && !alreadyHandled) {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const bitmap = await createImageBitmap(canvas);
                        const det = await ensureDetector();
                        const codes = await det.detect(bitmap);
                        if (codes.length) {
                            const raw = (codes[0].rawValue || '').trim();
                            if (raw && !alreadyHandled) {
                                alreadyHandled = true;
                                handleCode(raw);
                                return;
                            }
                        }
                    }
                } catch (e) {
                    console.error(e);
                    status.textContent = 'No pude leer. Mejora la luz o usa el campo manual.';
                }
                detectLoopId = requestAnimationFrame(step);
            };
            detectLoopId = requestAnimationFrame(step);
        }

        // ------------- cierre y Livewire -------------
        function forceCloseModal(id) {
            const el = document.getElementById(id);
            if (!el) return;

            // Obtén la instancia del modal
            const modal = bootstrap.Modal.getInstance(el);
            if (modal) {
                modal.hide(); // Cierra el modal
            } else {
                // Si la instancia no existe, créala e instanciarla
                const newModal = new bootstrap.Modal(el);
                newModal.hide();
            }

            // Elimina el fondo (backdrop)
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.classList.remove('show'); // Elimina la clase show del backdrop
                document.body.classList.remove('modal-open'); // Elimina la clase modal-open del body
                document.body.style.removeProperty('padding-right'); // Restaura el padding-right del body
            }

            // Fallback para asegurar que el modal se cierre correctamente
            setTimeout(() => {
                el.classList.remove('show'); // Elimina la clase show del modal
                document.querySelectorAll('.modal-backdrop.show').forEach(e => e
                    .remove()); // Elimina todos los backdrops visibles
            }, 300);
        }

        function handleCode(code) {
            stopCamera();
            forceCloseModal('scannerModal'); // Cierra el modal del escáner
            Livewire.dispatch('scanner:code-detected', {
                code
            }); // Dispara el evento Livewire

            console.log("Cerrando appModal...");

            // Asegúrate de cerrar appModal después de que el evento Livewire se procese
            setTimeout(() => {
                forceCloseModal(
                    'appModal'); // Asegura que appModal se cierre después de que se procese el código.
            }, 300); // Dale tiempo para el evento Livewire y el modal de confirmación
        }



        // ------------- eventos UI -------------
        btnUse?.addEventListener('click', () => {
            const code = (txtMan?.value || '').trim();
            if (!code) return;
            alreadyHandled = true;
            handleCode(code);
        });

        btnFlip?.addEventListener('click', async () => {
            usingBack = !usingBack;
            try {
                await startCamera();
            } catch {
                status.textContent = 'No pude cambiar cámara.';
            }
        });

        document.getElementById('scannerModal')?.addEventListener('shown.bs.modal', async () => {
            try {
                await ensureDetector();
                await startCamera();
            } catch (e) {
                console.error(e);
                status.innerHTML = 'Tu navegador no soporta escaneo. Usa el campo manual.';
            }
        });
        document.getElementById('scannerModal')?.addEventListener('hidden.bs.modal', stopCamera);
    })();
</script>
