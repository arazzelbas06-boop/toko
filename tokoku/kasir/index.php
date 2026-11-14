<?php
require '../config.php';
require_cashier();
$title = 'Dashboard Kasir';
$jumlah_transaksi = (int) $pdo->query('SELECT COUNT(*) FROM transaksi')->fetchColumn();
$total_penjualan = $pdo->query('SELECT COALESCE(SUM(total),0) FROM transaksi')->fetchColumn();
$jumlah_pelanggan = (int) $pdo->query('SELECT COUNT(*) FROM pelanggan')->fetchColumn();
$hari_ini = $pdo->prepare('SELECT COUNT(*), COALESCE(SUM(total),0) FROM transaksi WHERE tanggal = CURDATE()');
$hari_ini->execute();
$hari = $hari_ini->fetch(PDO::FETCH_NUM);
$terbaru = $pdo->query('SELECT id_transaksi, tanggal, nama_pelanggan, nama_barang, total FROM v_laporan_transaksi ORDER BY id_transaksi DESC LIMIT 6')->fetchAll();
include 'includes/header.php';
?>
<h1>Dashboard Kasir</h1>
<p class="sub">Selamat datang, <?= e(admin_name()) ?>. Kelola transaksi penjualan dengan cepat.</p>

<div class="report-banner cashier-banner"><div><span class="eyebrow">CASHIER DESK</span><h2>Siap melayani pelanggan hari ini?</h2><p>Catat transaksi baru dan pantau penjualan toko dari sini.</p></div><a class="btn" href="transaksi_form.php">+ Transaksi Baru</a></div>
<div class="grid"><div class="stat"><div class="label">Transaksi hari ini</div><div class="value"><?= e($hari[0]) ?></div><span class="stat-note"><?= rupiah($hari[1]) ?> nilai penjualan</span></div><div class="stat"><div class="label">Total transaksi</div><div class="value"><?= e($jumlah_transaksi) ?></div><span class="stat-note">seluruh periode</span></div><div class="stat"><div class="label">Pelanggan</div><div class="value"><?= e($jumlah_pelanggan) ?></div><span class="stat-note">terdaftar di sistem</span></div><div class="stat"><div class="label">Penjualan</div><div class="value value-small"><?= rupiah($total_penjualan) ?></div><span class="stat-note">akumulasi keseluruhan</span></div></div>

<div class="card"><div class="toolbar"><div><h2>Transaksi terbaru</h2><p class="sub">Aktivitas transaksi terakhir di toko.</p></div><a class="btn sec" href="transaksi.php">Lihat semua</a></div>
<?php tbl($terbaru, ['tanggal' => 'Tanggal', 'nama_pelanggan' => 'Pelanggan', 'nama_barang' => 'Barang', 'total' => 'Total'], ['total']); ?>
</div>
<?php include 'includes/footer.php'; ?>
