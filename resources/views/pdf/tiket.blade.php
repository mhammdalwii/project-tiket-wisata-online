<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket {{ $transaksi->kode_booking }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
        .ticket-container { border: 2px dashed #2563eb; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #1d4ed8; margin: 0; font-size: 24px; text-transform: uppercase; }
        .success-badge { color: #15803d; font-weight: bold; background-color: #dcfce7; padding: 5px 10px; border-radius: 5px; display: inline-block; margin-top: 10px; font-size: 14px;}
        .details { width: 100%; border-collapse: collapse; }
        .details th { text-align: left; padding: 10px 0; width: 40%; color: #6b7280; font-weight: normal; }
        .details td { text-align: left; padding: 10px 0; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>E-Ticket Wisata</h1>
            <div class="success-badge">✔ Pembayaran Lunas</div>
        </div>
        
        <table class="details">
            <tr>
                <th>Kode Booking</th>
                <td>: {{ $transaksi->kode_booking }}</td>
            </tr>
            <tr>
                <th>Nama Wisatawan</th>
                <td>: {{ $transaksi->user->name }}</td>
            </tr>
            <tr>
                <th>Destinasi</th>
                <td>: {{ $transaksi->wisata->nama_wisata }}</td>
            </tr>
            <tr>
                <th>Tanggal Kunjungan</th>
                <td>: {{ \Carbon\Carbon::parse($transaksi->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jumlah Tiket</th>
                <td>: {{ $transaksi->jumlah_tiket }} Orang</td>
            </tr>
            <tr>
                <th>Total Pembayaran</th>
                <td>: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            Tunjukkan E-Ticket ini (digital atau cetak) kepada petugas di loket wisata.<br>
            Terima kasih telah menggunakan Sistem Informasi Pemesanan Tiket Wisata Online.
        </div>
    </div>
</body>
</html>