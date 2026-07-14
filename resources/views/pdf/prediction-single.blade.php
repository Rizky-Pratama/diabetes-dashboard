<x-pdf.layout reportTitle="Hasil Prediksi Individual" :reportId="'PRD-' . str_pad($prediction->id, 5, '0', STR_PAD_LEFT)" :generatedBy="auth()->user()?->name" :metaExtra="[
    'ID Rekaman' => '#' . $prediction->id,
    'Tanggal Prediksi' => $prediction->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm'),
    'Subjek' => $prediction->patient_name ?? ($prediction->user?->name ?? 'Pengguna'),
]">

    {{-- ─── RESULT HIGHLIGHT ─── --}}
    <table class="result-highlight-table {{ $prediction->result ?? 'normal' }}">
        <tr>
            <td>
                <span class="result-label-title">Hasil Prediksi</span>
                <span class="result-label-value">
                    {{ match ($prediction->result) {
                        'diabetes' => 'Diabetes',
                        'prediabetes' => 'Prediabetes',
                        default => 'Normal',
                    } }}
                </span>
            </td>
            @if ($prediction->probability)
                <td class="text-right">
                    <span class="result-prob-label">Probabilitas Risiko</span>
                    <span
                        class="result-prob-value">{{ number_format((float) $prediction->probability * 100, 1) }}%</span>
                </td>
            @endif
        </tr>
    </table>

    {{-- ─── PARAMETER INPUT ─── --}}
    <div class="section-title">Parameter Pemeriksaan Kesehatan</div>
    <table class="detail-grid-table">
        <tr>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Glucose</span>
                    <span
                        class="detail-item-value">{{ filled($prediction->glucose) ? number_format((float) $prediction->glucose, 2) : '-' }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">BP</span>
                    <span
                        class="detail-item-value">{{ filled($prediction->blood_pressure) ? number_format((float) $prediction->blood_pressure, 2) : '-' }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Insulin</span>
                    <span
                        class="detail-item-value">{{ filled($prediction->insulin) ? number_format((float) $prediction->insulin, 2) : '-' }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">BMI</span>
                    <span
                        class="detail-item-value">{{ filled($prediction->bmi) ? number_format((float) $prediction->bmi, 2) : '-' }}</span>
                </div>
            </td>
            <td>
                <div class="detail-item">
                    <span class="detail-item-label">Usia</span>
                    <span class="detail-item-value">{{ $prediction->age ?? '-' }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── AUDIT TRAIL ─── --}}
    <div class="section-title">Informasi Audit</div>
    <table class="data-table">
        <tbody>
            <tr>
                <td class="font-bold" style="width: 30%; color: #64748b;">Subjek / Pasien</td>
                <td>{{ $prediction->patient_name ?? ($prediction->user?->name ?? '-') }}</td>
            </tr>
            @if ($prediction->user)
                <tr>
                    <td class="font-bold" style="color: #64748b;">Akun Pengguna</td>
                    <td>{{ $prediction->user->name }} ({{ $prediction->user->email }})</td>
                </tr>
            @endif
            @if ($prediction->inputBy)
                <tr>
                    <td class="font-bold" style="color: #64748b;">Diinput Oleh</td>
                    <td>{{ $prediction->inputBy->name }} ({{ $prediction->inputBy->email }})</td>
                </tr>
            @endif
            @if ($prediction->clinic)
                <tr>
                    <td class="font-bold" style="color: #64748b;">Klinik</td>
                    <td>{{ $prediction->clinic->nama_klinik }}</td>
                </tr>
            @endif
            <tr>
                <td class="font-bold" style="color: #64748b;">Waktu Prediksi</td>
                <td>{{ $prediction->created_at->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WIB</td>
            </tr>
        </tbody>
    </table>

</x-pdf.layout>
