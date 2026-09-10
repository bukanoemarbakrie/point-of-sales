<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $order->order_code }}</title>
    <style>
        body {
            width: 58mm;
            font-family: 'Courier New', Courier, monospace;
            /* Perbaikan: Tambah koma */
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <strong>Toko Kopi PPKD Jakarta Pusat</strong><br>
        Jl. Karet Pasar Baru Barat Nomor 23, Karet Tengsin, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta, 10250
    </div>
    <div class="line"></div>
    <div>Tanggal : {{ $order->created_at->format('d/m/Y H:i') }}</div>
    <div>Code : {{ $order->order_code }}</div>
    <div>Metode : {{ strtoupper($order->status === 1 ? 'CASH' : 'MIDTRANS') }}</div>
    <div class="line"></div>

    {{-- Hitung Subtotal & Pajak --}}
    @php
    $subtotal = 0;
    foreach($order->orderDetails as $detail) {
    $subtotal += $detail->order_subtotal;
    }
    $tax = $subtotal * 0.10;
    @endphp

    <table>
        @foreach ($order->orderDetails as $detail)
        <tr>
            <td><strong>{{ $detail->product->product_name }}</strong></td>
        </tr>
        <tr>
            <td>{{ $detail->order_qty }} × Rp. {{ number_format($detail->order_price, 0, ',', '.') }}</td>
            <td class="text-end">Rp. {{ number_format($detail->order_subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    {{-- BAGIAN YANG DITAMBAHKAN: Ringkasan Pembayaran --}}
    <table>
        <tr>
            <td>Sub Total</td>
            <td class="text-end">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pajak (10%)</td>
            <td class="text-end">Rp. {{ number_format($tax, 0, ',', '.') }}</td>
        </tr>
        <tr class="fw-bold">
            <td>Total</td>
            <td class="text-end">Rp. {{ number_format($order->order_amount, 0, ',', '.') }}</td>
        </tr>
        @if ($order->order_change > 0)
        <tr>
            <td>Kembali</td>
            <td class="text-end">Rp. {{ number_format($order->order_change, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div class="line"></div>
    <div class="text-center">
        -- Terima Kasih -- <br>
        Selamat Menikmati!
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
