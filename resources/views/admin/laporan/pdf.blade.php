<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan SIMANTAP</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; }
        th { background: #f0f0f0; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-success { color: #16a34a; }
        .text-danger { color: #dc2626; }
        .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: center; }
    </style>
</head>
<body>

    <h1>Laporan Keuangan SIMANTAP</h1>
    <div class="subtitle">
        Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="70">Tanggal</th>
                <th>Keterangan</th>
                <th width="80">Dicatat Oleh</th>
                <th class="text-right" width="80">Debit</th>
                <th class="text-right" width="80">Kredit</th>
                <th class="text-right" width="80">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $saldo = 0; @endphp
            @forelse($catatan as $i => $c)
                @php
                    $debit  = $c->nominal > 0 ? $c->nominal : 0;
                    $kredit = $c->nominal < 0 ? abs($c->nominal) : 0;
                    $saldo += $c->nominal;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $c->keterangan }}</td>
                    <td>{{ $c->user->nama ?? '-' }}</td>
                    <td class="text-right text-success">{{ $debit > 0 ? number_format($debit, 0, ',', '.') : '—' }}</td>
                    <td class="text-right text-danger">{{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '—' }}</td>
                    <td class="text-right">{{ number_format($saldo, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada catatan.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background: #f0f0f0; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right text-success">Rp {{ number_format($totalDebit ?? 0, 0, ',', '.') }}</td>
                <td class="text-right text-danger">Rp {{ number_format($totalKredit ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format(($totalDebit ?? 0) - ($totalKredit ?? 0), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak otomatis dari sistem SIMANTAP — {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>