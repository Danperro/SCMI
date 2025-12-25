<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte de Conectividad e Incidencias</title>
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
            background-color: #155529;
            /* VERDE FORMAL */
            border: 1px solid #000;
            padding: 10px 15px;
            color: white;
        }

        .encabezado .titulo h1,
        .encabezado .titulo h3 {
            color: white;
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

        .datos-generales,
        .fila-datos {
            display: table;
            width: 100%;
            justify-content: space-between;
            align-items: flex-start;
            border: 1px solid #000;
            padding: 6px 12px;
            margin-top: 5px;
            font-size: 11px;
        }

        .datos-generales p,
        .fila-datos p {
            margin: 0;
        }

        .titulo-seccion {
            background-color: #1e6b3a;
            /* VERDE FORMAL */
            font-weight: bold;
            text-align: left;
            padding: 5px;
            font-size: 11px;
            margin-top: 12px;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: none;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #155529;
            /* VERDE FORMAL */
            color: white;
            font-size: 10px;
        }

        td:first-child {
            text-align: left;
            font-size: 10px;
        }

        .firmas {
            margin-top: 20px;
        }

        .firmas td {
            height: 90px;
            vertical-align: top;
            text-align: center;
        }

        /* Anchos personalizados */
        .col-realizado {
            width: 25%;
        }

        .col-verificado {
            width: 25%;
        }

        .col-observaciones {
            width: 50%;
        }

        .fila-datos .info,
        .fila-datos .glosario {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .fila-datos .info {
            text-align: left;
        }

        .fila-datos .glosario {
            text-align: right;
        }
    </style>

</head>

<body>

    {{-- CABECERA --}}
    <div class="encabezado">
        <div class="titulo">
            <h1>CENTRO UNIVERSITARIO DE CONECTIVIDAD</h1>
            <h3>REPORTES de VALIDACION DEL ESTADO DE CONECTIVIDAD Y VERIFICACION DE INCIDENCIAS DE RIESGOS INFORMATICOS
            </h3>
        </div>
        <div class="logo">
            <img src="{{ public_path('images/CUCLOGO.png') }}" alt="logo">
        </div>
    </div>

    <div class="fila-datos">
        <div class="info">
            <p><strong>Laboratorio:</strong> {{ $detalleLab->laboratorio->NombreLab }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($detalleLab->FechaDtl)->format('d/m/Y') }}</p>
        </div>

        <div class="glosario">
            <p><strong>F:</strong> Falla &nbsp;&nbsp; <strong>✓:</strong> Correcto &nbsp;&nbsp;
                <strong>A:</strong> Actualizado &nbsp;&nbsp;<strong>P:</strong>Pendiente &nbsp;&nbsp;
            </p>
            <p> <strong>C:</strong>
                Cable &nbsp;&nbsp;<strong>W:</strong> Wifi &nbsp;&nbsp;
                <strong>✓:</strong> Realizado &nbsp;&nbsp; <strong>X:</strong> No realizado
            </p>
        </div>
    </div>



    {{-- TABLA HARDWARE --}}
    <div class="titulo-seccion">ESTADO DE CONECTIVIDAD E INCIDENCIAS</div>
    <table>
        <thead>
            <tr>
                <th>Estados e Incidencias</th>
                @foreach ($equipos as $eq)
                    <th>{{ $eq->NombreEqo }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($mantenimientos['HARDWARE'] ?? [] as $nombreMan => $fila)
                <tr>
                    <td>{{ $nombreMan }}</td>
                    @foreach ($equipos as $eq)
                        <td>{{ $fila[(int) $eq->IdEqo] ?? '' }}</td>
                    @endforeach
                </tr>
            @endforeach


        </tbody>
    </table>



    {{-- FIRMAS Y OBSERVACIONES --}}
    <table class="firmas">
        <thead>
            <tr>
                <th class="col-realizado">Realizado por:</th>
                <th class="col-verificado">Verificado por:</th>
                <th class="col-observaciones">Observaciones:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-realizado">{{ $detalleLab->RealizadoDtl ?? '---' }}</td>
                <td class="col-verificado"></td>
                <td class="col-observaciones"></td>
            </tr>
        </tbody>
    </table>


</body>

</html>
