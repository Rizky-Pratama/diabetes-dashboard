<x-pdf.layout reportTitle="Laporan Data Klinik" :reportId="'KLN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4))" :generatedBy="auth()->user()?->name" :metaExtra="[
    'Total Klinik' => $clinics->count() . ' klinik',
    'Tanggal Ekspor' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
]">

    {{-- ─── STAT CARDS ─── --}}
    @php
        $totalKlinik = $clinics->count();
        $totalPetugas = $clinics->sum('users_count');
        $totalPrediksi = $clinics->sum('predictions_count');
    @endphp
    <table class="stat-grid-table">
        <tr>
            <td>
                <div class="stat-card primary">
                    <span class="stat-label">Total Klinik Terdaftar</span>
                    <span class="stat-value">{{ $totalKlinik }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card warning">
                    <span class="stat-label">Total Petugas</span>
                    <span class="stat-value">{{ $totalPetugas }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card success">
                    <span class="stat-label">Total Data Prediksi</span>
                    <span class="stat-value">{{ $totalPrediksi }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card neutral">
                    <span class="stat-label">Rata-rata Prediksi/Klinik</span>
                    <span class="stat-value">{{ $totalKlinik > 0 ? round($totalPrediksi / $totalKlinik) : 0 }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── TABLE ─── --}}
    <div class="section-title">Daftar Klinik Terdaftar</div>

    @if ($clinics->isEmpty())
        <p style="text-align: center; color: #94a3b8; padding: 20px 0;">Belum ada data klinik terdaftar.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 22%;">Nama Klinik</th>
                    <th style="width: 28%;">Alamat</th>
                    <th style="width: 13%;">Telepon</th>
                    <th style="width: 16%;">Email</th>
                    <th style="width: 8%; text-align: center;">Petugas</th>
                    <th style="width: 8%; text-align: center;">Prediksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clinics as $i => $clinic)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="font-bold">{{ $clinic->nama_klinik }}</td>
                        <td style="color: #475569;">{{ $clinic->alamat ?? '-' }}</td>
                        <td>{{ $clinic->telepon ?? '-' }}</td>
                        <td>{{ $clinic->email ?? '-' }}</td>
                        <td class="text-center">{{ $clinic->users_count ?? 0 }}</td>
                        <td class="text-center">{{ $clinic->predictions_count ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-pdf.layout>
