<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre Cliente</th>
                <th>Identificación Cliente</th>
                <th>Correo Cliente</th>
                <th>Cantidad Productos</th>
                <th>Monto Total</th>
                <th>Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->code }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->customer_id }}</td>
                    <td>{{ $sale->customer_email }}</td>
                    <td>{{ $sale->products_count }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ $sale->sale_datetime }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
