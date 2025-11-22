<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte de Mantenimiento</title>
    <style>
        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
            font-weight: normal;
            src: url("fonts/DejaVuSans.ttf") format("truetype");
        }

        @page {
            margin: 10px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 8px;
        }

        .encabezado {
            width: 100%;
            display: table;
            /* DOMPDF-friendly */
            background-color: #cce4cc;
            border: 1px solid #000;
            padding: 10px 15px;
        }

        .encabezado .titulo {
            display: table-cell;
            width: 80%;
            vertical-align: middle;
            text-align: left;
        }

        .encabezado .titulo h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }

        .encabezado .titulo h3 {
            font-size: 13px;
            margin: 3px 0 0 0;
            font-weight: normal;
        }

        .encabezado .logo {
            display: table-cell;
            width: 20%;
            text-align: right;
            vertical-align: middle;
        }

        .encabezado .logo img {
            max-width: 100px;
            height: auto;
        }



        .datos-generales {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #000;
            padding: 6px 12px;
            margin-top: 5px;
            font-size: 11px;
        }

        .datos-generales p {
            margin: 0;
        }

        .fila-datos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #000;
            padding: 6px 10px;
            margin-top: 10px;
            font-size: 11px;
        }

        .fila-datos p {
            margin: 0;
        }


        .titulo-seccion {
            background-color: #a8d5a8;
            font-weight: bold;
            text-align: left;
            padding: 5px;
            font-size: 11px;
            margin-top: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 1px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #e0f2e0;
            font-size: 9px;
        }

        /* 👇 SOLO la columna de MANTENIMIENTO más grande y ancha */
        th.col-mant,
        td.col-mant {
            font-size: 10px;
            font-weight: bold;
            /* más grande el texto */
            padding: 4px;
            /* más espacio interno */
            text-align: left;
            width: 20%;
            /* más ancho */
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.4;
        }


        td:first-child {
            text-align: left;
            font-size: 8px;
        }

        .firmas {
            margin-top: 10px;
        }

        .firmas td {
            height: 100px;
            vertical-align: top;
            text-align: center;
        }

        td.man {
            font-size: 8px;
            font-weight: bold;
            padding: 4px;
        }
    </style>
</head>

<body>

    {{-- CABECERA --}}
    <div class="encabezado">
        <div class="titulo">
            <h1>CENTRO UNIVERSITARIO DE CONECTIVIDAD</h1>
            <h3>REPORTE DE MANTENIMIENTO PREVENTIVO A HARDWARE Y SOFTWARE</h3>
        </div>
        <div class="logo">
            <img src="{{ public_path('images/CUCLOGO.png') }}" alt="logo">
        </div>
    </div>


    {{-- DATOS GENERALES --}}
    <div class="fila-datos">
        <p><strong>Laboratorio:</strong> {{ $detalleLab->laboratorio->NombreLab }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($detalleLab->FechaDtl)->format('d/m/Y') }}</p>
    </div>

    {{-- TABLA HARDWARE --}}
    <div class="titulo-seccion">MANTENIMIENTO PREVENTIVO DE HARDWARE</div>
    <table>
        <thead>
            <tr>
                <th class="col-mant">MANTENIMIENTO</th>
                @foreach ($equipos as $eq)
                    <th>{{ $eq->NombreEqo }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($mantenimientos['HARDWARE'] ?? [] as $nombreMan => $checks)
                <tr>
                    <td class="man">{{ strtoupper($nombreMan) }}</td>
                    @foreach ($equipos as $eq)
                        <td>{{ $checks[$eq->IdEqo] ?? '' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TABLA SOFTWARE --}}
    <div class="titulo-seccion">MANTENIMIENTO PREVENTIVO DE SOFTWARE</div>
    <table>
        <thead>
            <tr>
                <th class="col-mant">MANTENIMIENTO</th>
                @foreach ($equipos as $eq)
                    <th>{{ $eq->NombreEqo }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($mantenimientos['SOFTWARE'] ?? [] as $nombreMan => $checks)
                <tr>
                    <td class="man">{{ strtoupper($nombreMan) }}</td>
                    @foreach ($equipos as $eq)
                        <td>{{ $checks[$eq->IdEqo] ?? '' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FIRMAS Y OBSERVACIONES --}}
    <table class="firmas">
        <thead>
            <tr>
                <th>Realizado por:</th>
                <th>Verificado por:</th>
                <th>Observaciones:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $detalleLab->RealizadoDtl ?? '---' }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
