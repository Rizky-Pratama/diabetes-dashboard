<x-pdf.layout reportTitle="Laporan Data Pengguna" :reportId="'USR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4))" :generatedBy="auth()->user()?->name" :metaExtra="[
    'Total Pengguna' => $users->count() . ' akun',
    'Tanggal Ekspor' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
]">

    {{-- ─── SUMMARY STATS ─── --}}
    @php
        $totalAdmin = $users->where('role', 'admin')->count();
        $totalPetugas = $users->where('role', 'petugas')->count();
        $totalPengguna = $users->where('role', 'pengguna')->count();
    @endphp

    {{-- ─── STAT CARDS ─── --}}
    <table class="stat-grid-table">
        <tr>
            <td>
                <div class="stat-card primary">
                    <span class="stat-label">Total Pengguna</span>
                    <span class="stat-value">{{ $users->count() }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card success">
                    <span class="stat-label">Admin</span>
                    <span class="stat-value">{{ $totalAdmin }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card warning">
                    <span class="stat-label">Petugas Klinik</span>
                    <span class="stat-value">{{ $totalPetugas }}</span>
                </div>
            </td>
            <td>
                <div class="stat-card danger">
                    <span class="stat-label">Pengguna (Pasien)</span>
                    <span class="stat-value">{{ $totalPengguna }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- ─── TABLE ─── --}}
    <div class="section-title">Daftar Pengguna Aplikasi</div>

    @if ($users->isEmpty())
        <p style="text-align: center; color: #94a3b8; padding: 20px 0;">Belum ada data pengguna.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Lengkap</th>
                    <th style="width: 20%;">Email / Kontak</th>
                    <th style="width: 10%; text-align: center;">Role</th>
                    <th style="width: 15%;">Klinik Asal</th>
                    <th style="width: 10%; text-align: center;">Prediksi</th>
                    <th style="width: 15%; text-align: center;">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="font-bold">{{ $user->name }}</td>
                        <td style="color: #475569;">{{ $user->email }}</td>
                        <td class="text-center">
                            <span
                                class="badge badge-{{ match ($user->role) {
                                    'admin' => 'danger',
                                    'petugas' => 'warning',
                                    default => 'neutral',
                                } }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->clinic?->nama_klinik ?? '-' }}</td>
                        <td class="text-center">{{ $user->predictions_count ?? 0 }}</td>
                        <td class="text-center nowrap">
                            {{ $user->created_at?->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-pdf.layout>
