<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Hasil Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, sans-serif; background: #f5f7fb; color: #111827; }
        .report-shell { max-width: 980px; margin: 32px auto; background: #fff; border: 1px solid #e2e8f0; border-radius: 24px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); padding: 32px; }
        .report-head { display: flex; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        .report-title { font-size: 1.75rem; font-weight: 900; margin: 0; }
        .report-sub { color: #4b5563; margin: 6px 0 0; }
        .report-card { border: 1px solid #e2e8f0; border-radius: 18px; padding: 16px; background: #f8fafc; }
        .report-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .report-actions { display: flex; gap: 8px; margin-bottom: 16px; }
        @media print { .no-print { display: none !important; } body { background: #fff; } .report-shell { box-shadow: none; border: 0; margin: 0; } }
    </style>
</head>
<body>
    <div class="report-shell">
        <div class="no-print report-actions">
            <button class="btn btn-warning" onclick="window.print()">Print</button>
            <button class="btn btn-outline-secondary" onclick="closeReport()">Tutup</button>
        </div>
        <div class="report-head">
            <div>
                <img src="{{ asset('images/logo.svg') }}" alt="APES" style="height:64px;">
                <h1 class="report-title mt-3">Cetak Hasil Penilaian</h1>
                <p class="report-sub">Ringkasan hasil penilaian 360 berbasis AKHLAK.</p>
            </div>
            <div class="report-card text-end">
                <div class="fw-bold">Sinta Lestari</div>
                <div>Finance - Senior Analyst</div>
                <div class="mt-2"><strong>94.8</strong> | Grade A</div>
            </div>
        </div>
        <div class="report-grid">
            <div class="report-card">
                <h5>Data Karyawan</h5>
                <div>NIP: P-2026-0148</div>
                <div>Periode: Triwulan II 2026</div>
            </div>
            <div class="report-card">
                <h5>Komponen 360</h5>
                <div>Atasan: 95.0</div>
                <div>Rekan: 94.0</div>
                <div>Bawahan: 92.0</div>
                <div>Self: 95.0</div>
            </div>
        </div>
    </div>
    <script>
        function closeReport() {
            if (window.opener && !window.opener.closed) {
                window.close();
                return;
            }

            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            window.location.href = "{{ route('dashboard.direktur') }}";
        }
    </script>
</body>
</html>
