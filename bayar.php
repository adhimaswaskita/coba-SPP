<?php 

include "./includes/header.php";
include "includes/functions.php";


if(isset($_POST['submit'])) {
    $tahun = $_POST['years'];
    $bulan = $_POST['submit'];
}

$selectMonthIdResult = getMonth($bulan);

$month = mysqli_fetch_assoc($selectMonthIdResult);
$monthId = $month['id'];
$monthName = $month['nama'];

if (isset($_POST['kirim'])) {
    $perihal = $_POST['perihal'];
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $bukti_pembayaran_temp = $_FILES['bukti_pembayaran']['tmp_name'];
    move_uploaded_file($bukti_pembayaran, "./assets/images/bukti/$bukti_pembayaran");
    $catatan = $_POST['catatan'];
    $status = $_POST['status'];
    $tahun = $_POST['tahun'];
    $id_siswa = $_POST['id_siswa'];
    $id_bulan = $_POST['id_bulan'];
    
    $insertQuery = "INSERT INTO pembayaran(perihal, bukti_pembayaran, catatan, status, tahun, id_siswa, id_bulan) VALUES('$perihal', '$bukti_pembayaran', '$catatan', '$status', '$tahun', '$id_siswa', '$id_bulan')";

    $insertResult = mysqli_query($connection, $insertQuery);
    if(!$insertResult) {
        die(mysqli_error($connection));
    }

    header("Location: dashboard.php");
}

?>

<div class="form-container">
    <h1>Pembayaran SPP Bulan <?php echo $monthName ?></h1>

    <form action="bayar.php" method="post" enctype="multipart/form-data" >

        <label for="perihal">Perihal</label> <br>
        <input type="text" name="perihal" placeholder="Pembayaran SPP Bulan Juli"> <br>
        <label for="bukti_pembayaran">Bukti Pembayaran</label> <br>
        <input type="file" name="bukti_pembayaran"> <br>
        <label for="catatan">Catatan</label> <br>
        <input type="text" name="catatan" placeholder="Catatan untuk pembayaran SPP"> <br>
        <input type="hidden" name="status" value="pending">
        <input type="hidden" name="tahun" value="<?php echo $tahun; ?>">
        <input type="hidden" name="id_siswa" value=1>
        <input type="hidden" name="id_bulan" value="<?php echo $monthId ?>">
        <input type="submit" name="kirim" value="Kirim Bukti">

    </form>
</div>

<?php include("./includes/footer.php"); ?>