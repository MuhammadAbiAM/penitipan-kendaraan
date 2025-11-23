@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Dashboard</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        {{-- Statistik Box --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-sign-in-alt fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0">Motor Masuk Hari Ini</h6>
                            <h3 class="fw-bold">{{ $motorMasuk }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-sign-out-alt fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0">Motor Keluar Hari Ini</h6>
                            <h3 class="fw-bold">{{ $motorKeluar }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-motorcycle fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0">Total Motor masuk</h6>
                            <h3 class="fw-bold">{{ $totalMotor }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik --}}
        <div class="row">
            {{-- Grafik Mingguan --}}
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-2">Grafik Mingguan</h5>
                        <div class="d-flex align-items-center mb-3">
                            <h3 class="fw-bold text-primary me-4">{{ $totalMasukMinggu }}</h3>
                            <span class="text-muted me-5">Total Masuk</span>
                            <h3 class="fw-bold text-warning me-2">{{ $totalKeluarMinggu }}</h3>
                            <span class="text-muted">Total Keluar</span>
                        </div>
                        <canvas id="grafikMingguan" height="150"
                            data-labels='@json($labelsMinggu ?? [])' data-masuk='@json($dataMasukMinggu ?? [])'
                            data-keluar='@json($dataKeluarMinggu ?? [])'>
                        </canvas>
                    </div>
                </div>
            </div>

            {{-- Grafik Slot Penitipan --}}
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-3">Slot Penitipan Motor</h5>
                        <canvas id="grafikSlot" width="200" height="200" class="mb-3"
                            data-terisi='@json($slotTerisi ?? 0)' data-tersedia='@json($slotTersedia ?? 0)'>
                        </canvas>
                        <div class="d-flex justify-content-center">
                            <div class="me-4">
                                <span class="badge bg-success me-1">&nbsp;</span> Slot Terisi: {{ $slotTerisi }}
                            </div>
                            <div>
                                <span class="badge bg-warning me-1">&nbsp;</span> Slot Tersedia: {{ $slotTersedia }}
                            </div>
                        </div>
                        <p class="mt-3 text-muted small">Total Slot: <strong>{{ $totalSlot }}</strong> Tempat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- FUNGSI UTAMA UNTUK MENGAMBIL KONTEKS CANVAS ---
            function createChart(elementId, chartConfig) {
                const canvas = document.getElementById(elementId);
                // Pastikan elemen canvas ditemukan
                if (canvas) {
                    // Coba ambil konteks 2D
                    const ctx = canvas.getContext('2d');
                    if (ctx) {
                        new Chart(ctx, chartConfig);
                    } else {
                        console.error('Failed to get 2D context for canvas ID:', elementId);
                    }
                } else {
                    console.error('Canvas element not found for ID:', elementId);
                }
            }
            // ----------------------------------------------------


            // --- GRAFIK MINGGUAN ---
            const canvasMingguan = document.getElementById('grafikMingguan');
            if (canvasMingguan) {
                // Ambil data dari atribut data- di elemen canvas
                const labelsMinggu = JSON.parse(canvasMingguan.dataset.labels);
                const dataMasukMinggu = JSON.parse(canvasMingguan.dataset.masuk);
                const dataKeluarMinggu = JSON.parse(canvasMingguan.dataset.keluar);

                createChart('grafikMingguan', {
                    type: 'bar',
                    data: {
                        // Menggunakan variabel JS yang sudah dibaca dari DOM
                        labels: labelsMinggu,
                        datasets: [{
                                label: 'Motor Masuk',
                                data: dataMasukMinggu,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)'
                            },
                            {
                                label: 'Motor Keluar',
                                data: dataKeluarMinggu,
                                backgroundColor: 'rgba(255, 206, 86, 0.7)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }


            // --- GRAFIK SLOT PENITIPAN ---
            const canvasSlot = document.getElementById('grafikSlot');
            if (canvasSlot) {
                // Ambil data dari atribut data- di elemen canvas
                const slotTerisi = JSON.parse(canvasSlot.dataset.terisi);
                const slotTersedia = JSON.parse(canvasSlot.dataset.tersedia);

                createChart('grafikSlot', {
                    type: 'doughnut',
                    data: {
                        labels: ['Slot Terisi', 'Slot Tersedia'],
                        datasets: [{
                            // Menggunakan variabel JS yang sudah dibaca dari DOM
                            data: [slotTerisi, slotTersedia],
                            backgroundColor: ['#28a745', '#ffc107']
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
