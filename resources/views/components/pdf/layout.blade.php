<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $reportTitle ?? 'Laporan DiabPredict' }}</title>
    <style>
        /* CSS Reset & wkhtmltopdf specific fixes */
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background: #ffffff;
            /* line-height: 1.7;
            letter-spacing: 0.3px;
            word-spacing: 0.6px; */
        }

        /* ─── PAGE LAYOUT ─── */
        .page {
            padding: 20px 30px;
        }

        /* Helper for layout without flexbox (wkhtmltopdf lacks full flex support) */
        .w-full {
            width: 100%;
        }

        .table-layout {
            display: table;
            width: 100%;
        }

        .table-cell {
            display: table-cell;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* ─── HEADER ─── */
        .header {
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-logo {
            height: 45px;
            vertical-align: middle;
        }

        .header-logo-placeholder {
            display: inline-block;
            width: 45px;
            height: 45px;
            background-color: #0ea5e9;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            line-height: 45px;
            vertical-align: middle;
        }

        .header-brand-info {
            display: block;
            vertical-align: middle;
            margin-left: 10px;
        }

        .header-brand-tagline {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .header-report-label {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #94a3b8;
            /* letter-spacing: 1px; */
        }

        .header-report-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
            margin: 2px 0;
        }

        .header-report-id {
            font-size: 11px;
            color: #64748b;
        }

        /* ─── META INFO BAR ─── */
        .meta-bar {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 15px;
        }

        .meta-item {
            padding-right: 20px;
        }

        .meta-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            display: block;
            margin-bottom: 2px;
        }

        .meta-value {
            font-size: 12px;
            font-weight: bold;
            color: #334155;
        }

        /* ─── SECTION TITLE ─── */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0ea5e9;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
            margin-bottom: 8px;
            margin-top: 15px;
        }

        /* ─── DATA TABLE ─── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table th {
            background-color: #1e293b;
            color: #ffffff;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            border: 1px solid #1e293b;
        }

        .data-table td {
            padding: 8px 10px;
            font-size: 12px;
            color: #334155;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* ─── BADGE / STATUS ─── */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-neutral {
            background-color: #f1f5f9;
            color: #475569;
        }

        /* ─── STAT CARDS (wkhtmltopdf safe) ─── */
        .stat-grid-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-left: -10px;
            margin-bottom: 15px;
        }

        .stat-card {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            background-color: #ffffff;
        }

        .stat-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            display: block;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
        }

        .stat-card.danger .stat-value {
            color: #dc2626;
        }

        .stat-card.warning .stat-value {
            color: #d97706;
        }

        .stat-card.success .stat-value {
            color: #16a34a;
        }

        .stat-card.primary .stat-value {
            color: #0ea5e9;
        }

        /* ─── DETAIL GRID ─── */
        .detail-grid-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-left: -8px;
            margin-bottom: 15px;
        }

        .detail-item {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px;
            background-color: #f8fafc;
        }

        .detail-item-label {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            display: block;
            margin-bottom: 3px;
        }

        .detail-item-value {
            font-size: 15px;
            font-weight: bold;
            color: #1e293b;
        }

        /* ─── RESULT HIGHLIGHT ─── */
        .result-highlight-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background-color: #f8fafc;
        }

        .result-highlight-table td {
            padding: 12px 16px;
            border-radius: 4px;
        }

        .result-highlight-table.diabetes td {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
        }

        .result-highlight-table.prediabetes td {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }

        .result-highlight-table.normal td {
            background-color: #dcfce7;
            border-left: 4px solid #16a34a;
        }

        .result-label-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            display: block;
            margin-bottom: 2px;
        }

        .result-label-value {
            font-size: 22px;
            font-weight: bold;
        }

        .result-highlight-table.diabetes .result-label-value {
            color: #dc2626;
        }

        .result-highlight-table.prediabetes .result-label-value {
            color: #d97706;
        }

        .result-highlight-table.normal .result-label-value {
            color: #16a34a;
        }

        .result-prob-label {
            font-size: 11px;
            color: #64748b;
            display: block;
            margin-bottom: 2px;
        }

        .result-prob-value {
            font-size: 26px;
            font-weight: bold;
            color: #1e293b;
        }

        /* ─── RECOMMENDATION BOX ─── */
        .recommendation-box {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 10px 12px;
            margin-bottom: 15px;
            background-color: #f8fafc;
        }

        .recommendation-box-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0ea5e9;
            margin-bottom: 5px;
        }

        .recommendation-box p {
            font-size: 12px;
            color: #475569;
            margin: 2px 0;
        }

        /* ─── TTD SECTION ─── */
        .signature-table {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table td {
            text-align: center;
            width: 33.33%;
            vertical-align: top;
            padding: 0 10px;
        }

        .signature-label {
            font-size: 11px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .signature-city-date {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 50px;
        }

        .signature-name {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            text-decoration: underline;
        }

        .signature-title {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ─── FOOTER (positioned at bottom of page) ─── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 30px;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            background-color: #ffffff;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>

<body>
    {{-- ─── FOOTER (Fixed to bottom, must be declared before content for wkhtmltopdf) ─── --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    Dicetak pada: <strong>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WIB</strong>
                    |
                    Oleh: <strong>{{ $generatedBy ?? (auth()->user()?->name ?? 'Sistem') }}</strong> |
                    Aplikasi: <strong>DiabPredict v1.0</strong>
                </td>
                <td class="text-right">
                    <strong>{{ $reportTitle ?? 'Laporan DiabPredict' }}</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">
        {{-- ─── HEADER ─── --}}
        <div class="header">
            <table class="table-layout">
                <tr>
                    <td style="width: 60%;">
                        @if (file_exists(public_path('logo.png')))
                            <img src="{{ public_path('logo.png') }}" alt="DiabPredict" class="header-logo">
                        @else
                            <div class="header-logo-placeholder">D</div>
                        @endif
                        <div class="header-brand-info">
                            <div class="header-brand-tagline">Sistem Prediksi Risiko Diabetes</div>
                        </div>
                    </td>
                    <td class="text-right" style="width: 40%; vertical-align: bottom;">
                        <div class="header-report-label">Dokumen Resmi</div>
                        <div class="header-report-title">{{ $reportTitle ?? 'Laporan' }}</div>
                        <div class="header-report-id">No.
                            {{ $reportId ?? 'LPR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)) }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ─── META INFO BAR ─── --}}
        <div class="meta-bar">
            <table class="table-layout">
                <tr>
                    <td class="meta-item" style="width: auto;">
                        <span class="meta-label">Dicetak oleh</span>
                        <span class="meta-value">{{ $generatedBy ?? (auth()->user()?->name ?? 'Sistem') }}</span>
                    </td>
                    <td class="meta-item" style="width: auto;">
                        <span class="meta-label">Tanggal Cetak</span>
                        <span class="meta-value">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                            WIB</span>
                    </td>
                    @isset($metaExtra)
                        @foreach ($metaExtra as $label => $value)
                            <td class="meta-item" style="width: auto;">
                                <span class="meta-label">{{ $label }}</span>
                                <span class="meta-value">{{ $value }}</span>
                            </td>
                        @endforeach
                    @endisset
                </tr>
            </table>
        </div>

        {{-- ─── MAIN CONTENT ─── --}}
        <div class="content">
            {{ $slot }}
        </div>

        {{-- ─── TTD SECTION ─── --}}
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-label">Mengetahui</div>
                    <div class="signature-city-date">Cileungsi,
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </div>
                    <div class="signature-name">
                        {{ $signerOneName ?? '( .......................................... )' }}</div>
                    <div class="signature-title">{{ $signerOneTitle ?? 'Kepala / Penanggung Jawab' }}</div>
                </td>
                <td>
                    <div class="signature-label">Diperiksa oleh</div>
                    <div class="signature-city-date">Cileungsi,
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </div>
                    <div class="signature-name">
                        {{ $signerTwoName ?? '( .......................................... )' }}</div>
                    <div class="signature-title">{{ $signerTwoTitle ?? 'Operator / Petugas' }}</div>
                </td>
                <td>
                    <div class="signature-label">Dibuat oleh</div>
                    <div class="signature-city-date">Cileungsi,
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </div>
                    <div class="signature-name">
                        {{ auth()->user()?->name ?? '( .......................................... )' }}</div>
                    <div class="signature-title">{{ ucfirst(auth()->user()?->role ?? 'Sistem') }}</div>
                </td>
            </tr>
        </table>

        <div style="text-align: center; font-size: 10px; color: #94a3b8; margin-top: 15px;">
            Dokumen ini digenerate secara otomatis oleh sistem DiabPredict dan merupakan dokumen resmi yang sah.
        </div>
    </div>
</body>

</html>
