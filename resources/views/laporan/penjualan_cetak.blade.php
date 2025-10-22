<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 20px;
            color: #000;
        }

        h2, h4 {
            margin: 0;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .text-end { text-align: right; }
        .text-center { text-align: center; }

        .total {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            font-size: 15px;
        }

        @media print {
            @page { size: A4 portrait; margin: 15mm; }
        }
    </style>
</head>
<body>
    <h2>LAPORAN PENJUALAN</h2>
    <h4>Periode: {{ \Carbon\Carbon::parse($tanggal_awal)->translatedFormat('d M Y') }} 
        s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d M Y') }}</h4>

    <table>
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th>Nama Pasien</th>
                <th>Petugas</th>
                <th>Tanggal</th>
                <th>Total (Rp)</th>
                <th>Catatan</th>
                <th>Detail Item</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPendapatan = 0; @endphp
            @foreach($data as $i => $t)
                @php $totalPendapatan += $t->total; @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $t->pasien->nama ?? '-' }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>{{ $t->catatan ?? '-' }}</td>
                    <td>
                        <table style="width:100%; border: none; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="border:1px solid #ccc;">Nama Item</th>
                                    <th style="border:1px solid #ccc;">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($t->detail as $d)
                                    <tr>
                                        <td style="border:1px solid #ccc;">{{ $d->nama_item }}</td>
                                        <td style="border:1px solid #ccc;" class="text-end">
                                            Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
