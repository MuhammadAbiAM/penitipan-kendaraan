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
            width: 230px;
            padding: 12px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            background: #fff;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .sub-title {
            font-size: 13px;
            margin-top: 4px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin: 3px 0;
        }

        .divider {
            text-align: center;
            font-size: 12px;
            margin: 6px 0;
            letter-spacing: 1px;
        }

        .qr-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 20px;
            text-align: center;
        }

        .qr-box p {
            margin: 0;
        }

        .qr-box hr {
            margin: 3px 0;
        }

        .kode-struk {
            margin-top: 2px;
            margin-bottom: 0;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
        }

        @media print {
            body {
                background: #fff !important;
                margin: 0;
                padding: 0;
            }

            .ticket {
                margin: 0;
                border: none !important;
                width: 230px !important;
                padding: 8px;
            }
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

        <div class="divider">----------------------------------------------</div>

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

        <div class="divider">----------------------------------------------</div>

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
                            {{ \Carbon\Carbon::parse($penitipan->waktu_keluar)->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
                    </span>
                </p>
                <div class="info-row">
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
            <div class="qr-box">
                <p>{!! QrCode::size(100)->generate($penitipan->kode_struk) !!}</p>
                <hr>
            </div>
        </div>

        <p class="kode-struk">
            <strong>{{ $penitipan->kode_struk }}</strong>
        </p>

        <div class="divider">----------------------------------------------</div>

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan penitipan kendaraan kami!</p>
        </div>

    </div>
</body>

</html>
