<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penitipan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Penitipan Kendaraan</h2>
    <p>Tanggal: {{ now()->format('d-m-Y H:i') }}</p>
    <p>Total Pendapatan: <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Nomor</th>
                <th>Merek</th>
                <th>Warna</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penitipan as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->plat_nomor }}</td>
                    <td>{{ $row->merek }}</td>
                    <td>{{ $row->warna }}</td>
                    <td>{{ $row->waktu_masuk }}</td>
                    <td>{{ $row->waktu_keluar ?? '-' }}</td>
                    <td>Rp {{ number_format($row->total_biaya, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
