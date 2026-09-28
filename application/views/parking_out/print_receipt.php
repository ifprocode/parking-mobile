<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($app_name) ?> - Struk Bayar</title>
    <style>
        @page { margin: 0; size: 58mm auto; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            width: 58mm;
            margin: 0 auto;
            padding: 5px;
            text-align: left;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        td { padding: 1px 0; font-size: 11px; vertical-align: top; }
        @media print { body { padding: 0; } * { -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body onload="window.print(); setTimeout(function(){ window.close(); }, 500);">
    
    <div class="text-center" style="font-size: 12px; margin-bottom: 5px;">
        STRUK BAYAR PARKIR
    </div>
    
    <div class="text-center text-bold" style="font-size: 13px; margin-bottom: 10px;">
        <?= htmlspecialchars($app_name) ?>
    </div>
    
    <div style="margin-bottom: 5px; font-size: 10px;">
        <?= $trx->receipt_number ?>
    </div>
    
    <div style="margin-bottom: 5px;">
        NOPOL : <?= htmlspecialchars($trx->plate_number) ?>
    </div>
    
    <table>
        <tr>
            <td style="width: 25%;">IN</td>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;"><?= date('d-m-Y H:i:s', strtotime($trx->time_in)) ?></td>
        </tr>
        <tr>
            <td>OUT</td>
            <td>:</td>
            <td><?= date('d-m-Y H:i:s', strtotime($trx->time_out)) ?></td>
        </tr>
        <tr>
            <td>LAMA</td>
            <td>:</td>
            <td><?= $duration_exact ?></td>
        </tr>
        <tr>
            <td>BIAYA</td>
            <td>:</td>
            <td>Rp <?= number_format($trx->total_fare, 0, ',', '.') ?></td>
        </tr>
    </table>
    
    <div class="text-center" style="margin-top: 15px; font-size: 11px;">
        TERIMA KASIH
    </div>

</body>
</html>
