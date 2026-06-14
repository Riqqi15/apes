<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Hasil Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, sans-serif; background: #f5f7fb; color: #111827; }
        .report-shell { max-width: 1040px; margin: 32px auto; background: #fff; border: 1px solid #e2e8f0; border-radius: 24px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); padding: 32px; }
        .report-head { display: flex; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        .report-title { font-size: 1.75rem; font-weight: 900; margin: 0; }
        .report-sub { color: #4b5563; margin: 6px 0 0; }
        .report-card { border: 1px solid #e2e8f0; border-radius: 18px; padding: 16px; background: #f8fafc; }
        .report-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .report-actions { display: flex; gap: 8px; margin-bottom: 16px; }
        .report-bars { display: grid; gap: 10px; }
        .report-bar { display: grid; grid-template-columns: 170px 1fr 56px; gap: 12px; align-items: center; }
        .report-track { height: 10px; background: #eaf2ff; border-radius: 999px; overflow: hidden; }
        .report-track span { display: block; height: 100%; background: linear-gradient(90deg, #f6c445, #d99a00); border-radius: inherit; }
        @media print { .no-print { display: none !important; } body { background: #fff; } .report-shell { box-shadow: none; border: 0; margin: 0; } }
    </style>
</head>
<body>
    <div class="report-shell">
        <div class="no-print report-actions">
            <button class="btn btn-warning" onclick="window.print()">Print</button>
            <button class="btn btn-outline-warning" onclick="window.print()">Export PDF</button>
            <button class="btn btn-outline-secondary" onclick="closeReport()">Tutup</button>
        </div>
        <div class="report-head">
            <div>
                <img src="{{ asset('images/logo.svg') }}" alt="APES" style="height:64px;">
                <h1 class="report-title mt-3">Cetak Hasil Penilaian</h1>
                <p class="report-sub">Ringkasan hasil penilaian 360 berbasis AKHLAK.</p>
            </div>
            <div class="report-card text-end">
                <div class="fw-bold">{{ $report['name'] }}</div>
                <div>{{ $report['department'] }} - {{ $report['position'] }}</div>
                <div class="mt-2"><strong>{{ $report['final'] }}</strong> | Grade {{ $report['grade'] }}</div>
            </div>
        </div>
        <div class="report-grid">
            <div class="report-card">
                <h5>Data Karyawan</h5>
                <div>NIP: {{ $report['nip'] }}</div>
                <div>Periode: {{ $report['period'] }}</div>
            </div>
            <div class="report-card">
                <h5>Komponen 360</h5>
                @foreach($report['components'] as $component)
                    <div>{{ $component['label'] }}: {{ $component['value'] }}</div>
                @endforeach
            </div>
        </div>
        <div class="report-card mt-3">
            <h5>Skor AKHLAK per Variable</h5>
            <div class="report-bars mt-3">
                @foreach($report['variables'] as $variable)
                    <div class="report-bar">
                        <strong>{{ $variable['name'] }}</strong>
                        <div class="report-track"><span style="width: {{ $variable['score'] }}%"></span></div>
                        <strong>{{ $variable['score'] }}</strong>
                    </div>
                @endforeach
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

            window.location.href = "{{ route('rekap') }}";
        }
    </script>
</body>
</html>
