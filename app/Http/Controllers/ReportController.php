<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\PredictionHistory;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * Report #1 — Laporan Hasil Prediksi Individual.
     * Akses: semua role yang authenticated.
     */
    public function predictionSingle(PredictionHistory $prediction): Response
    {
        $user = Auth::user();

        // Pengguna biasa hanya bisa cetak milik sendiri
        if ($user->role === 'pengguna') {
            abort_unless((int) $prediction->user_id === $user->id, 403);
        }

        // Petugas hanya bisa cetak dari kliniknya
        if ($user->role === 'petugas') {
            abort_unless((int) $prediction->clinic_id === $user->clinic_id, 403);
        }

        $prediction->load(['user', 'inputBy', 'clinic']);

        $pdf = PDF::loadView('pdf.prediction-single', compact('prediction'))
            ->setPaper('a4')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '45mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('enable-local-file-access', true);

        $filename = 'prediksi-' . str_pad($prediction->id, 5, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Report #2 — Laporan Riwayat Prediksi Pribadi.
     * Akses: pengguna (miliknya), petugas (kliniknya), admin (semua).
     */
    public function predictionHistory(Request $request): Response
    {
        $user = Auth::user();
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = PredictionHistory::with(['user', 'inputBy', 'clinic'])
            ->latest();

        if ($user->role === 'pengguna') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'petugas') {
            $query->where('clinic_id', $user->clinic_id);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($startDate));
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($endDate));
        }

        $histories = $query->get();

        $formattedStart = $startDate ? Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM YYYY') : null;
        $formattedEnd = $endDate ? Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM YYYY') : null;

        $pdf = PDF::loadView('pdf.prediction-history', [
            'histories' => $histories,
            'startDate' => $formattedStart,
            'endDate' => $formattedEnd,
        ])
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '45mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('enable-local-file-access', true);

        $filename = 'riwayat-prediksi-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Report #3 — Laporan Rekap Prediksi Keseluruhan (Admin).
     * Akses: admin saja.
     */
    public function predictionSummary(Request $request): Response
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $baseQuery = PredictionHistory::query();

        if ($startDate) {
            $baseQuery->whereDate('created_at', '>=', Carbon::parse($startDate));
        }

        if ($endDate) {
            $baseQuery->whereDate('created_at', '<=', Carbon::parse($endDate));
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'normal' => (clone $baseQuery)->where('result', 'normal')->count(),
            'prediabetes' => (clone $baseQuery)->where('result', 'prediabetes')->count(),
            'diabetes' => (clone $baseQuery)->where('result', 'diabetes')->count(),
            'avg_glucose' => (clone $baseQuery)->avg('glucose') ?? 0,
            'avg_blood_pressure' => (clone $baseQuery)->avg('blood_pressure') ?? 0,
            'avg_insulin' => (clone $baseQuery)->avg('insulin') ?? 0,
            'avg_bmi' => (clone $baseQuery)->avg('bmi') ?? 0,
            'avg_age' => (clone $baseQuery)->avg('age') ?? 0,
            'total_clinics' => Clinic::count(),
        ];

        $monthlyData = (clone $baseQuery)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN result = 'normal' THEN 1 ELSE 0 END) as normal")
            ->selectRaw("SUM(CASE WHEN result = 'prediabetes' THEN 1 ELSE 0 END) as prediabetes")
            ->selectRaw("SUM(CASE WHEN result = 'diabetes' THEN 1 ELSE 0 END) as diabetes")
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at) DESC, MONTH(created_at) DESC')
            ->get();

        $formattedStart = $startDate ? Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM YYYY') : null;
        $formattedEnd = $endDate ? Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM YYYY') : null;

        $pdf = PDF::loadView('pdf.prediction-summary', [
            'stats' => $stats,
            'monthlyData' => $monthlyData,
            'startDate' => $formattedStart,
            'endDate' => $formattedEnd,
        ])
            ->setPaper('a4')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '45mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('enable-local-file-access', true);

        $filename = 'rekap-prediksi-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Report #4 — Laporan Data Pengguna (Admin).
     * Akses: admin saja.
     */
    public function users(): Response
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $users = User::with('clinic')
            ->withCount(['predictionHistories as predictions_count'])
            ->latest()
            ->get();

        $pdf = PDF::loadView('pdf.users', compact('users'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '45mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('enable-local-file-access', true);

        $filename = 'data-pengguna-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Report #5 — Laporan Data Klinik (Admin).
     * Akses: admin saja.
     */
    public function clinics(): Response
    {
        abort_unless(Auth::user()->role === 'admin', 403);

        $clinics = Clinic::withCount(['users', 'predictionHistories as predictions_count'])
            ->orderBy('nama_klinik')
            ->get();

        $pdf = PDF::loadView('pdf.clinics', compact('clinics'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '45mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('enable-local-file-access', true);

        $filename = 'data-klinik-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->stream($filename);
    }
}
