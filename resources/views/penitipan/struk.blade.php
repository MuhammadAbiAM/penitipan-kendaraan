<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Penitipan Kendaraan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/title.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4;
            background: #f5f5f5;
        }

        .ticket {
            border: 1px solid #000;
            padding: 20px;
            width: 300px;
            margin: 20px auto;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .sub-title {
            font-size: 14px;
            margin-top: 4px;
            margin-bottom: 30px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 12px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .info p {
            margin: 3px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin: 3px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .left {
            width: 60%;
        }

        .qr-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 10px;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 18px;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 12px 0;
        }
    </style>
</head>

<body>
    <div class="ticket">

        <div class="header">
            <h2>PELABUHAN SDP</h2>
            <h2>DINAS PERHUBUNGAN</h2>
            <h2>KABUPATEN CILACAP</h2>
            <div class="sub-title">Struk Penitipan Kendaraan</div>
        </div>

        <div class="row">
            <div class="left">
                <p class="info-row">
                    <span><strong>Tanggal:</strong></span>
                    <span>{{ now()->format('d-m-Y H:i') }}</span>
                </p>

                @if ($penitipan->user)
                    <p class="info-row">
                        <span><strong>Petugas:</strong></span>
                        <span>{{ $penitipan->user->username }}</span>
                    </p>
                @endif
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="left">
                <p class="info-row">
                    <span><strong>Plat Nomor:</strong></span>
                    <span>{{ $penitipan->plat_nomor }}</span>
                </p>
                <p class="info-row">
                    <span><strong>Waktu Masuk:</strong></span>
                    <span>{{ $penitipan->waktu_masuk ? \Carbon\Carbon::parse($penitipan->waktu_masuk)->format('d-m-Y H:i') : '-' }}</span>
                </p>
                <p class="info-row">
                    <span><strong>Waktu Keluar:</strong></span>
                    <span>
                        @if ($penitipan->waktu_keluar)
                            {{ $penitipan->waktu_keluar ? \Carbon\Carbon::parse($penitipan->waktu_keluar)->format('d-m-Y H:i') : '-' }}
                        @else
                            -
                        @endif
                    </span>
                </p>
                <div class="info-row" style="margin-top: 10px; font-size: 16px;">
                    <strong>Total Bayar:</strong>
                    <span>
                        @if ($penitipan->status == 'selesai' && $penitipan->total_biaya)
                            Rp {{ number_format($penitipan->total_biaya, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="qr-container">
            <div>
                <p><strong>QR Code</strong></p>
                {!! QrCode::size(120)->generate($penitipan->kode_struk) !!}
                <p style="margin-top: 8px; font-size: 12px;">
                    <strong>{{ $penitipan->kode_struk }}</strong>
                </p>
            </div>
        </div>


        <div class="footer">
            <hr>
            <p>Terima kasih telah menggunakan layanan penitipan kendaraan kami!</p>
            {{-- <p>Harap simpan struk ini sebagai bukti resmi penitipan.</p>
            <p>Kehilangan struk dapat menyulitkan proses pengambilan kendaraan.</p> --}}
        </div>

    </div>
</body>

</html>
