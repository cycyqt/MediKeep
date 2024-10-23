<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <img src="https://i.ibb.co/gt0zTSh/Logo-2.png" alt="Logo" style="float: right; max-width: 150px; height: auto;">

    <h1>Order Confirmation</h1>
    <p>Dear {{ $supplier->name }},</p>
    <p>A new order has been placed by {{ $order->staff_id }} on {{ $order->order_date }}.</p>

    <h2>Order Details:</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($validatedData['product_id'] as $index => $productId)
                <tr>
                    <td>{{ $products[$index]->name }}</td>
                    <td>{{ $validatedData['quantity'][$index] }}</td>
                    <td>{{ number_format($validatedData['unit_price'][$index], 2) }}</td>
                    <td>{{ number_format($validatedData['total_price'][$index], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
