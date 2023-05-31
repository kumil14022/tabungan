<?php 
	require_once 'koneksi.php';

	if (!isset($_SESSION['id_user'])) {
		header("Location: index.php");
		exit;
	}

	$id_user = $_SESSION['id_user'];

	$user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
	$data_user = mysqli_fetch_assoc($user);

	if (isset($_GET['btnLaporan'])) {
		$jenis_transaksi = htmlspecialchars($_GET['jenis_transaksi']);
		$dari_tanggal = htmlspecialchars($_GET['dari_tanggal']);
    $sampai_tanggal = htmlspecialchars($_GET['sampai_tanggal']);

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
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laporan</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- memanggil topbar -->
  <?php include_once 'include/topbar.php'; ?>
  
  <!-- memanggil sidebar -->
  <?php include_once 'include/sidebar.php'; ?>

  <main>
  	<h1>Laporan Tabungan</h1>
  	<div class="form">
	  	<form method="get">
	  		<div>
            <label for="dari_tanggal">Dari Tanggal</label>
            <input class="input-field" type="date" name="dari_tanggal"
                value="<?= isset($_GET['btnLaporan']) ? $dari_tanggal : date('Y-m-01'); ?>">
        </div>
        <div>
            <label for="sampai_tanggal">Sampai Tanggal</label>
            <input class="input-field" type="date" name="sampai_tanggal"
                value="<?= isset($_GET['btnLaporan']) ? $sampai_tanggal : date('Y-m-d'); ?>">
        </div>
	  		<div>
	  			<label for="jenis_transaksi">Jenis Transaksi</label>
	  			<select name="jenis_transaksi" id="jenis_transaksi" class="input-field">
	  				<option value="SEMUA">SEMUA</option>
	  				<option value="SETORAN">SETORAN</option>
	  				<option value="TARIKAN">TARIKAN</option>
	  			</select>
	  		</div>
	  		<div>
	  			<button type="submit" name="btnLaporan" class="button">Filter</button>
	  		</div>
	  	</form>
  	</div>
    <br><br>
    <?php if (isset($_GET['btnLaporan'])): ?>
    	<a href="print_laporan.php?dari_tanggal=<?= $dari_tanggal; ?>&sampai_tanggal=<?= $sampai_tanggal; ?>&jenis_transaksi=<?= $jenis_transaksi; ?>" target="_blank" class="button">Print</a>
    	<h3>Laporan Tabungan - Dari Tanggal <?= date("d-m-Y", strtotime($dari_tanggal)); ?> Sampai Tanggal <?= date("d-m-Y", strtotime($sampai_tanggal)); ?></h3>
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
		<?php endif ?>		  	
  </main>
</body>
</html>