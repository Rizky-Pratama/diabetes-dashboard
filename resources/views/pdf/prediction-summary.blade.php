<x-pdf.layout
    reportTitle="Rekap Prediksi Keseluruhan"
    :reportId="'RKP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4))"
    :generatedBy="auth()->user()?->name"
    :metaExtra="array_filter([
        'Total Prediksi' => $stats['total'] . ' rekaman',
        'Periode'        => ($startDate && $endDate) ? $startDate . ' s/d ' . $endDate : 'Semua waktu',
        'Total Klinik'   => $stats['total_clinics'] . ' klinik',
    ])">

    {{-- ─── STAT CARDS ─── --}}
    <table class="stat-grid-table">
        <tr>
            <td>
                <div class="stat-card primary">
                    <span class="stat-label">Total Prediksi</span>
                    <span class="stat-value">{{ $stats['total'] }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card success">
                    <span class="stat-label">Normal</span>
                    <span class="stat-value">{{ $stats['normal'] }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card warning">
                    <span class="stat-label">Prediabetes</span>
                    <span class="stat-value">{{ $stats['prediabetes'] }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card danger">
                    <span class="stat-label">Diabetes</span>
                    <span class="stat-value">{{ $stats['diabetes'] }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── PERCENTAGE BAR ─── --}}
    @if ($stats['total'] > 0)
        @php
            $pNormal      = round($stats['normal'] / $stats['total'] * 100, 1);
            $pPrediabetes = round($stats['prediabetes'] / $stats['total'] * 100, 1);
            $pDiabetes    = round($stats['diabetes'] / $stats['total'] * 100, 1);
        @endphp
        <div style="margin-bottom: 20px;">
            <div class="section-title">Distribusi Hasil (%)</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Kategori</th>
                        <th style="width: 15%; text-align: center;">Jumlah</th>
                        <th style="width: 15%; text-align: center;">Persentase</th>
                        <th>Proporsi Visual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-bold" style="color: #16a34a;">Normal</td>
                        <td class="text-center">{{ $stats['normal'] }}</td>
                        <td class="text-center">{{ $pNormal }}%</td>
                        <td>
                            <div style="background: #f1f5f9; border-radius: 4px; height: 10px;">
                                <div style="background: #16a34a; height: 10px; border-radius: 4px; width: {{ $pNormal }}%;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="color: #d97706;">Prediabetes</td>
                        <td class="text-center">{{ $stats['prediabetes'] }}</td>
                        <td class="text-center">{{ $pPrediabetes }}%</td>
                        <td>
                            <div style="background: #f1f5f9; border-radius: 4px; height: 10px;">
                                <div style="background: #f59e0b; height: 10px; border-radius: 4px; width: {{ $pPrediabetes }}%;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="color: #dc2626;">Diabetes</td>
                        <td class="text-center">{{ $stats['diabetes'] }}</td>
                        <td class="text-center">{{ $pDiabetes }}%</td>
                        <td>
                            <div style="background: #f1f5f9; border-radius: 4px; height: 10px;">
                                <div style="background: #dc2626; height: 10px; border-radius: 4px; width: {{ $pDiabetes }}%;"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    {{-- ─── AVERAGE PARAMETERS ─── --}}
    <div class="section-title">Rata-rata Parameter Kesehatan Pasien</div>
    <table class="detail-grid-table">
        <tr>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Glucose</span>
                    <span class="detail-item-value">{{ number_format((float) $stats['avg_glucose'], 2) }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Blood Pressure</span>
                    <span class="detail-item-value">{{ number_format((float) $stats['avg_blood_pressure'], 2) }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Insulin</span>
                    <span class="detail-item-value">{{ number_format((float) $stats['avg_insulin'], 2) }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">BMI</span>
                    <span class="detail-item-value">{{ number_format((float) $stats['avg_bmi'], 2) }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Usia (Tahun)</span>
                    <span class="detail-item-value">{{ number_format((float) $stats['avg_age'], 1) }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── MONTHLY DATA ─── --}}
    <div class="section-title">Tren Rekapitulasi Bulanan</div>
    @if ($monthlyData->isEmpty())
        <p style="text-align: center; color: #94a3b8; padding: 20px 0;">Belum ada data bulanan.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th style="text-align: center;">Total</th>
                    <th style="text-align: center;">Normal</th>
                    <th style="text-align: center;">Prediabetes</th>
                    <th style="text-align: center;">Diabetes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyData as $row)
                    <tr>
                        <td class="font-bold">{{ \Carbon\Carbon::createFromDate($row->year, $row->month, 1)->locale('id')->isoFormat('MMMM YYYY') }}</td>
                        <td class="text-center">{{ $row->total }}</td>
                        <td class="text-center" style="color: #16a34a;">{{ $row->normal ?? 0 }}</td>
                        <td class="text-center" style="color: #d97706;">{{ $row->prediabetes ?? 0 }}</td>
                        <td class="text-center" style="color: #dc2626;">{{ $row->diabetes ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-pdf.layout>
