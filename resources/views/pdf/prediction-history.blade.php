<x-pdf.layout reportTitle="Riwayat Prediksi Pribadi" :reportId="'RWY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4))" :generatedBy="auth()->user()?->name" :metaExtra="array_filter([
    'Pengguna' => auth()->user()?->name,
    'Total Data' => $histories->count() . ' rekaman',
    'Periode' => $startDate && $endDate ? $startDate . ' s/d ' . $endDate : 'Semua waktu',
])">

    {{-- ─── SUMMARY STATS ─── --}}
    @php
        $totalCount = $histories->count();
        $diabetesCount = $histories->where('result', 'diabetes')->count();
        $prediabetesCount = $histories->where('result', 'prediabetes')->count();
        $normalCount = $histories->where('result', 'normal')->count();
    @endphp

    <table class="stat-grid-table">
        <tr>
            <td>
                <div class="stat-card primary">
                    <span class="stat-label">Total Prediksi</span>
                    <span class="stat-value">{{ $totalCount }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card success">
                    <span class="stat-label">Normal</span>
                    <span class="stat-value">{{ $normalCount }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card warning">
                    <span class="stat-label">Prediabetes</span>
                    <span class="stat-value">{{ $prediabetesCount }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card danger">
                    <span class="stat-label">Diabetes</span>
                    <span class="stat-value">{{ $diabetesCount }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── TABLE ─── --}}
    <div class="section-title">Rincian Riwayat Prediksi</div>

    @if ($histories->isEmpty())
        <p style="text-align: center; color: #94a3b8; padding: 20px 0;">Belum ada data prediksi.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 15%;">Pasien</th>
                    <th style="width: 9%; text-align: center;">Glucose</th>
                    <th style="width: 9%; text-align: center;">BP</th>
                    <th style="width: 9%; text-align: center;">Insulin</th>
                    <th style="width: 8%; text-align: center;">BMI</th>
                    <th style="width: 5%; text-align: center;">Usia</th>
                    <th style="width: 12%; text-align: center;">Probabilitas</th>
                    <th style="width: 13%; text-align: center;">Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $i => $history)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="nowrap">{{ $history->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY') }}<br>
                            <span class="text-muted">{{ $history->created_at->format('H:i') }}</span>
                        </td>
                        <td>{{ $history->patient_name ?? ($history->user?->name ?? '-') }}</td>
                        <td class="text-center">
                            {{ filled($history->glucose) ? number_format((float) $history->glucose, 1) : '-' }}</td>
                        <td class="text-center">
                            {{ filled($history->blood_pressure) ? number_format((float) $history->blood_pressure, 1) : '-' }}
                        </td>
                        <td class="text-center">
                            {{ filled($history->insulin) ? number_format((float) $history->insulin, 1) : '-' }}</td>
                        <td class="text-center">
                            {{ filled($history->bmi) ? number_format((float) $history->bmi, 1) : '-' }}</td>
                        <td class="text-center">{{ $history->age ?? '-' }}</td>
                        <td class="text-center">
                            {{ filled($history->probability) ? number_format((float) $history->probability * 100, 1) . '%' : '-' }}
                        </td>
                        <td class="text-center">
                            <span
                                class="badge badge-{{ match ($history->result) {
                                    'diabetes' => 'danger',
                                    'prediabetes' => 'warning',
                                    default => 'success',
                                } }}">
                                {{ $history->result_label }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-pdf.layout>
