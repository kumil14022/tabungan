<?php
    require_once 'koneksi.php';
    
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];

    $user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    $data_user = mysqli_fetch_assoc($user);

    $dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
    $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);
    $jenis_transaksi = htmlspecialchars($_GET['jenis_transaksi']);

    $dari_tanggal_baru =  $dari_tanggal . ' 00:00:00';
    $sampai_tanggal_baru =  $sampai_tanggal . ' 23:59:59';

    if ($jenis_transaksi == 'SEMUA') {
        $riwayat_tabungan = mysqli_query($koneksi, "SELECT * FROM riwayat_tabungan INNER JOIN tabungan ON riwayat_tabungan.id_tabungan = tabungan.id_tabungan INNER JOIN siswa ON tabungan.id_siswa = siswa.id_siswa 
            WHERE riwayat_tabungan.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'
        ");

        $total_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(CASE WHEN riwayat_tabungan.jenis_transaksi = 'SETORAN' THEN nominal ELSE -nominal END) as total_tabungan FROM tabungan INNER JOIN riwayat_tabungan ON riwayat_tabungan.id_tabungan = tabungan.id_tabungan WHERE riwayat_tabungan.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru'"));
    } else {
        $riwayat_tabungan = mysqli_query($koneksi, "SELECT * FROM riwayat_tabungan INNER JOIN tabungan ON riwayat_tabungan.id_tabungan = tabungan.id_tabungan INNER JOIN siswa ON tabungan.id_siswa = siswa.id_siswa 
            WHERE riwayat_tabungan.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' AND riwayat_tabungan.jenis_transaksi = '$jenis_transaksi'
        ");

        $total_tabungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT *, sum(CASE WHEN riwayat_tabungan.jenis_transaksi = 'SETORAN' THEN nominal ELSE -nominal END) as total_tabungan FROM tabungan INNER JOIN riwayat_tabungan ON riwayat_tabungan.id_tabungan = tabungan.id_tabungan WHERE riwayat_tabungan.tanggal_transaksi BETWEEN '$dari_tanggal_baru' AND '$sampai_tanggal_baru' AND riwayat_tabungan.jenis_transaksi = '$jenis_transaksi'"));
    }
?>

<html>
<head>
    <title>Laporan Tabungan - Dari Tanggal <?= date("d-m-Y", strtotime($dari_tanggal)); ?> Sampai Tanggal <?= date("d-m-Y", strtotime($sampai_tanggal)); ?> dengan Jenis Transaksi <?= $jenis_transaksi; ?></title>
</head>
<body>
    <h3>Laporan Tabungan - Dari Tanggal <?= date("d-m-Y", strtotime($dari_tanggal)); ?> Sampai Tanggal <?= date("d-m-Y", strtotime($sampai_tanggal)); ?> dengan Jenis Transaksi <?= $jenis_transaksi; ?></h3>
    <h4>Total Nominal: Rp. <?= number_format($total_tabungan['total_tabungan']); ?></h4>
    <table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Siswa</th>
            <th>Tanggal Transaksi</th>
            <th>Jenis Transaksi</th>
            <th>Nominal Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($riwayat_tabungan as $data_riwayat_tabungan): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $data_riwayat_tabungan['nama_siswa']; ?></td>
                <td><?= date("d-m-Y", strtotime($data_riwayat_tabungan['tanggal_transaksi'])); ?></td>
                <td><?= $data_riwayat_tabungan['jenis_transaksi']; ?></td>
                <td>Rp. <?= number_format($data_riwayat_tabungan['nominal']); ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  <script>window.print();</script>
</body>
</html>