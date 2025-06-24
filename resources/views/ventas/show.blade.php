@extends('layouts.app')

@section('title', 'Detalle de la Venta')

@section('content')
<!-- Contenido normal para pantalla -->
<div class="no-print">
    <div class="page-header">
        <h2><i class="fas fa-receipt"></i> Detalle de la Venta</h2>
        <p>Información completa de la venta realizada</p>
    </div>

    <div class="card">
        <h3><i class="fas fa-info-circle"></i> Información de la Venta</h3>
        
        <div class="table-container">
            <table class="table">
                <tr>
                    <th style="width: 200px;">ID Venta</th>
                    <td>{{ str_pad($venta->ID_Venta, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>{{ $venta->cliente->Nombres ?? 'N/A' }} {{ $venta->cliente->Apellidos ?? '' }}</td>
                </tr>
                <tr>
                    <th>DNI Cliente</th>
                    <td>{{ $venta->cliente->DNI ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $venta->cliente->Telefono ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Fecha de Venta</th>
                    <td>{{ $venta->Fecha->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td style="font-size: 1.3rem; font-weight: bold; color: #feca57;">
                        S/ {{ number_format($venta->Total, 2) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card">
        <h3><i class="fas fa-list"></i> Detalles de Productos</h3>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->Nombre ?? 'N/A' }}</td>
                        <td style="font-weight: bold;">{{ $detalle->Cantidad }}</td>
                        <td>S/ {{ number_format($detalle->Precio, 2) }}</td>
                        <td style="font-weight: bold; color: #feca57;">
                            S/ {{ number_format($detalle->Cantidad * $detalle->Precio, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top: 2px solid rgba(255, 255, 255, 0.3);">
                        <th colspan="3" style="text-align: right; font-size: 1.2rem;">TOTAL:</th>
                        <th style="font-size: 1.3rem; color: #feca57;">
                            S/ {{ number_format($venta->Total, 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Venta
        </a>
        <a href="{{ route('ventas.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Volver a Lista
        </a>
        <button onclick="imprimirBoleta()" class="btn btn-success">
            <i class="fas fa-print"></i> Imprimir Boleta
        </button>
    </div>
</div>

<!-- BOLETA PARA IMPRIMIR -->
<div class="print-only" id="boleta" style="display: none;">
    <div class="boleta-container">
        <!-- Header de la empresa -->
        <div class="boleta-header">
            <div class="empresa-info">
                <h1>SALÓN DE BELLEZA NUO3</h1>
                <p>De: Administración del Salón</p>
                <p>Jr. Belleza Nro. 123 - Independencia - Lima</p>
                <p>Telf: (01) 123-4567 Cel: 987-654-321</p>
                <p>E-mail: contacto@salonnuo3.com</p>
            </div>
            <div class="boleta-numero">
                <div class="ruc-box">
                    R.U.C. 20123456789<br>
                    <strong>BOLETA DE VENTA</strong>
                </div>
                <div class="numero-box">
                    <strong>N°: {{ str_pad($venta->ID_Venta, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>
        </div>

        <!-- Fecha -->
        <div class="fecha-box">
            <table class="fecha-table">
                <tr>
                    <td>DIA</td>
                    <td>MES</td>
                    <td>AÑO</td>
                </tr>
                <tr>
                    <td>{{ $venta->Fecha->format('d') }}</td>
                    <td>{{ $venta->Fecha->format('m') }}</td>
                    <td>{{ $venta->Fecha->format('y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Info del cliente -->
        <div class="cliente-info">
            <p><strong>Señor(es):</strong> {{ $venta->cliente->Nombres ?? 'N/A' }} {{ $venta->cliente->Apellidos ?? '' }}</p>
            <p><strong>Dirección:</strong> ..................................................................................<strong>D.I.:</strong> {{ $venta->cliente->DNI ?? 'N/A' }}</p>
        </div>

        <!-- Tabla de productos -->
        <div class="productos-table">
            <table>
                <thead>
                    <tr>
                        <th class="cant">CANT.</th>
                        <th class="descripcion">DESCRIPCIÓN</th>
                        <th class="precio">P. UNITARIO</th>
                        <th class="importe">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                    <tr>
                        <td class="cant">{{ $detalle->Cantidad }}</td>
                        <td class="descripcion">{{ strtoupper($detalle->producto->Nombre ?? 'N/A') }}</td>
                        <td class="precio">S/ {{ number_format($detalle->Precio, 2) }}</td>
                        <td class="importe">S/ {{ number_format($detalle->Cantidad * $detalle->Precio, 2) }}</td>
                    </tr>
                    @endforeach
                    
                    <!-- Filas vacías para completar la boleta -->
                    @for($i = count($venta->detalles); $i < 8; $i++)
                    <tr>
                        <td class="cant">&nbsp;</td>
                        <td class="descripcion">&nbsp;</td>
                        <td class="precio">&nbsp;</td>
                        <td class="importe">&nbsp;</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-box">
                <strong>TOTAL S/. {{ number_format($venta->Total, 2) }}</strong>
            </div>
            <div class="emisor">
                <strong>EMISOR</strong>
            </div>
        </div>

        <!-- Footer -->
        <div class="boleta-footer">
            <p>{{ now()->format('d/m/Y H:i') }} - Sistema de Gestión NUO3</p>
        </div>
    </div>
</div>

<style>
.no-print {
    display: block;
}

.print-only {
    display: none;
}

@media print {
    .no-print {
        display: none !important;
    }
    
    .print-only {
        display: block !important;
    }
    
    body {
        background: white !important;
        color: black !important;
    }
    
    .boleta-container {
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 20px;
        border: 2px solid black;
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.2;
        background: white;
        color: black;
    }
    
    .boleta-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        border-bottom: 1px solid black;
        padding-bottom: 10px;
    }
    
    .empresa-info h1 {
        font-size: 18px;
        font-weight: bold;
        margin: 0 0 5px 0;
    }
    
    .empresa-info p {
        margin: 2px 0;
        font-size: 11px;
    }
    
    .boleta-numero {
        text-align: center;
    }
    
    .ruc-box, .numero-box {
        border: 2px solid black;
        padding: 5px;
        margin: 2px;
        font-size: 11px;
    }
    
    .fecha-box {
        float: right;
        margin: 10px 0;
    }
    
    .fecha-table {
        border-collapse: collapse;
        border: 1px solid black;
    }
    
    .fecha-table td {
        border: 1px solid black;
        padding: 3px 8px;
        text-align: center;
        font-size: 11px;
    }
    
    .cliente-info {
        clear: both;
        margin: 15px 0;
    }
    
    .cliente-info p {
        margin: 5px 0;
        font-size: 11px;
    }
    
    .productos-table {
        margin: 20px 0;
    }
    
    .productos-table table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
    }
    
    .productos-table th,
    .productos-table td {
        border: 1px solid black;
        padding: 4px;
        font-size: 10px;
    }
    
    .productos-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        text-align: center;
    }
    
    .cant {
        width: 60px;
        text-align: center;
    }
    
    .descripcion {
        width: auto;
        text-align: left;
    }
    
    .precio, .importe {
        width: 80px;
        text-align: right;
    }
    
    .total-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
    }
    
    .total-box {
        border: 2px solid black;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
    }
    
    .emisor {
        border: 1px solid black;
        padding: 5px 10px;
        font-size: 12px;
    }
    
    .boleta-footer {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        text-align: center;
        font-size: 10px;
        border-top: 1px solid black;
        padding-top: 5px;
    }
}
</style>

<script>
function imprimirBoleta() {
    // Mostrar la boleta
    document.getElementById('boleta').style.display = 'block';
    
    // Esperar un momento para que se renderice
    setTimeout(function() {
        window.print();
        
        // Ocultar la boleta después de imprimir
        setTimeout(function() {
            document.getElementById('boleta').style.display = 'none';
        }, 100);
    }, 100);
}
</script>
@endsection