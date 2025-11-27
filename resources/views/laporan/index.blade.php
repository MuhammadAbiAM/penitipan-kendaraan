@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold mb-1">Laporan Pendapatan</h3>
        <p class="text-muted">{{ now()->translatedFormat('d F Y') }}</p>

        {{-- Tombol Export --}}
        <div class="mb-3">
            <a href="{{ route('laporan.pdf') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('laporan.excel') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>

        {{-- Kartu Statistik Ringkas --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm border-0 p-3">
                    <h6 class="fw-semibold">Total Masuk</h6>
                    <h3 class="fw-bold">{{ $totalMasuk ?? 0 }}</h3>
                    <i class="bi bi-box-arrow-in-down fs-2 opacity-50 position-absolute end-0 me-3"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm border-0 p-3">
                    <h6 class="fw-semibold">Total Keluar</h6>
                    <h3 class="fw-bold">{{ $totalKeluar ?? 0 }}</h3>
                    <i class="bi bi-box-arrow-up fs-2 opacity-50 position-absolute end-0 me-3"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm border-0 p-3">
                    <h6 class="fw-semibold">Total Pendapatan</h6>
                    <h3 class="fw-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                    <i class="bi bi-cash-coin fs-2 opacity-50 position-absolute end-0 me-3"></i>
                </div>
            </div>
        </div>

        {{-- Grafik Pendapatan Bulanan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Grafik Pendapatan Bulanan (12 Bulan Terakhir)</h5>
                <canvas id="pendapatanChart" height="80" data-chart='@json(['labels' => $labels ?? [], 'data' => $data ?? []])'>
                </canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('pendapatanChart');

            if (canvas) {
                const ctx = canvas.getContext('2d');

                let labelsData = [];
                let pendapatanData = [];

                try {
                    const chartDataAttr = canvas.dataset.chart;

                    const chartPayload = JSON.parse(chartDataAttr);

                    labelsData = chartPayload.labels;
                    pendapatanData = chartPayload.data;
                } catch (e) {
                    console.error(
                        "Gagal memparsing data chart dari atribut data-chart. Pastikan variabel $labels dan $data terdefinisi dan valid di Controller.",
                        e);
                }

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelsData,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: pendapatanData,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(context
                                            .raw);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
