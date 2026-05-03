<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label - {{ $barang->kode_barang }}</title>
    @php
        // QR Code mengarah ke URL Detail Barang
        $urlDetail = route('barang.show', $barang->id);
        $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)
            ->margin(1)
            ->generate($urlDetail);
    @endphp
    <style>
        /* Pengaturan Ukuran Kertas Stiker */
        @page {
            size: 64mm 32mm;
            margin: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            width: 64mm;
            height: 32mm;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
        }

        .label-box {
            width: 62mm; /* Sisakan sedikit ruang agar tidak terpotong printer */
            height: 30mm;
            border: 2px solid black;
            box-sizing: border-box;
            display: flex;
            overflow: hidden;
        }

        /* Sisi Kiri: QR Code */
        .left-side {
            flex: 0 0 22mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 2px solid black;
            padding: 2px;
        }

        .qr-code svg {
            width: 18mm;
            height: 18mm;
        }

        .id-text {
            font-size: 7px;
            font-weight: bold;
            margin-top: 2px;
            text-align: center;
        }

        /* Sisi Kanan: Informasi */
        .right-side {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #cccccc;
            border-bottom: 2px solid black;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            padding: 3px 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            flex-grow: 1;
        }

        table td {
            font-size: 8px;
            padding: 2px 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .field-label {
            font-weight: bold;
            width: 35%;
            border-right: 1px solid black;
        }

        .field-value {
            width: 65%;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        @media print {
            body { margin: 0; }
            .label-box { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="label-box">
        <!-- Bagian QR Code -->
        <div class="left-side">
            <div class="qr-code">
                {!! $qrCodeSvg !!}
            </div>
            <div class="id-text">{{ $barang->kode_barang }}</div>
        </div>

        <!-- Bagian Tabel Informasi -->
        <div class="right-side">
            <div class="header">
                INVENTARIS SEKOLAH AL BIRUNI
            </div>
            <table>
                <tr>
                    <td class="field-label">ID Barang</td>
                    <td class="field-value">: {{ $barang->kode_barang }}</td>
                </tr>
                <tr>
                    <td class="field-label">Nama Barang</td>
                    <td class="field-value">: {{ Str::limit($barang->nama_barang, 20) }}</td>
                </tr>
                <tr>
                    <td class="field-label">Lokasi</td>
                    <td class="field-value">: {{ $barang->namaRuang ? $barang->namaRuang->nama_ruang : '-' }}</td>
                </tr>
                <tr>
                    <td class="field-label">Tgl Perolehan</td>
                    <td class="field-value">: {{ $barang->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
