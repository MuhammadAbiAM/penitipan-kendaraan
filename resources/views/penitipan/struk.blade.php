<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Penitipan Kendaraan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }

        .ticket {
            border: 2px dashed #000;
            padding: 20px;
            width: 500px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 15px;
        }

        .info p {
            margin: 4px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .left {
            width: 60%;
        }

        .qr {
            width: 35%;
            text-align: center;
        }

        .qr img {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            <h2>Dinas Perhubungan</h2>
            <p><strong>Struk Penitipan Kendaraan</strong></p>
            <hr>
        </div>

        <div class="row">
            <div class="left">
                <div class="info">
                    {{-- <p><strong>Kode Tiket:</strong> {{ $penitipan->kode_tiket }}</p> --}}
                    <p><strong>Plat Nomor:</strong> {{ $penitipan->plat_nomor }}</p>
                    {{-- <p><strong>Pemilik:</strong> {{ $penitipan->kendaraan->pemilik->nama }}</p> --}}
                    <p><strong>Masuk:</strong> {{ $penitipan->waktu_masuk }}</p>
                </div>
            </div>
            <div class="qr">
                <p><strong>Scan QR</strong></p>
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(120)->generate($penitipan->kode_struk)) !!}" alt="QR Code">
            </div>
            <p style="margin-top:20px;">
                Kode Struk: <strong>{{ $penitipan->kode_struk }}</strong>
            </p>
            <small>Scan QR Code untuk pembayaran / validasi</small>
        </div>

        <div class="footer">
            <hr>
            <p>Harap simpan struk ini untuk validasi saat kendaraan keluar.</p>
        </div>
    </div>
</body>

</html>
