<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>
    <style>
        @page {
            margin: 0;
            size: 58mm auto; /* approximate thermal width */
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 58mm;
            margin: 0 auto;
            padding: 5px;
            text-align: left;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .dashed-line { border-bottom: 1px dashed #000; margin: 8px 0; }
        
        table { width: 100%; border-collapse: collapse; }
        td { padding: 1px 0; font-size: 11px; }
        
        img.qr { width: 35mm; height: 35mm; display: block; margin: 10px auto 5px auto; }
        img.barcode { width: 40mm; height: 12mm; display: block; margin: 10px auto 5px auto; }
        
        @media print {
            body { padding: 0; }
            * { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(function(){ window.close(); }, 500);">
    <div class="dashed-line"></div>
    
    <div class="text-center text-bold" style="font-size: 13px;">
        <?= htmlspecialchars($app_name) ?><br>
        <span style="font-weight: normal; font-size: 12px;">Tiket Masuk</span>
    </div>
    
    <div class="dashed-line"></div>
    
    <table>
        <tr>
            <td style="width: 38%; vertical-align: top;">Nomor Tiket</td>
            <td style="width: 5%; vertical-align: top;">:</td>
            <td style="width: 57%;"><?= $trx->receipt_number ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Plat Nomor</td>
            <td style="vertical-align: top;">:</td>
            <td><?= htmlspecialchars($trx->plate_number) ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Waktu Masuk</td>
            <td style="vertical-align: top;">:</td>
            <td><?= date('d/m/Y H:i:s', strtotime($trx->time_in)) ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Pos</td>
            <td style="vertical-align: top;">:</td>
            <td>GATE 1 (Masuk)</td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Total Tarif</td>
            <td style="vertical-align: top;">:</td>
            <td>Rp <?= number_format($trx->total_fare, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Status</td>
            <td style="vertical-align: top;">:</td>
            <td>LUNAS</td>
        </tr>
    </table>
    
    <div class="dashed-line"></div>
    
    <div class="text-center">
        <!-- Using external APIs for QR and Barcode generation as requested -->
        <img class="qr" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $trx->receipt_number ?>" alt="QR">
        <div style="font-size: 11px; margin-top: 5px;">SCAN QR SAAT KELUAR</div>
        
        <img class="barcode" src="https://bwipjs-api.metafloor.com/?bcid=code128&text=<?= $trx->receipt_number ?>&includetext=false" alt="Barcode">
        
        <div style="font-size: 10px; margin-top: 8px;">58mm x 110mm</div>
    </div>

</body>
</html>
