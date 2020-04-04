<?php 
include "includes/db.php";

function getCardInfo() {
    global $connection;
    $query = "SELECT bulan.id, bulan.nama, pembayaran.status, pembayaran.tahun FROM bulan LEFT JOIN pembayaran ON bulan.id = pembayaran.id_bulan";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die(mysqli_error($result));
    }
    return $result;
}

function getUserArrears($id_siswa) {
    global $connection;
    $month = date('n');
    $sumQuery = "SELECT SUM(bulan.nominal) FROM bulan LEFT JOIN pembayaran ON ";
    $sumQuery .= "bulan.id = pembayaran.id_bulan WHERE NOT (pembayaran.status = 'success') OR pembayaran.status IS null AND bulan.id <= $month AND pembayaran.id_siswa = $id_siswa;";
    $sumResult = mysqli_query($connection, $sumQuery);
    if (!$sumResult) {
        die(mysqli_error($sumResult));
    }
    return $sumResult;
}

function getProfileInfo($id_siswa) {
    global $connection;
    $profileQuery = "SELECT * FROM siswa WHERE id = $id_siswa";
    $profileResult = mysqli_query($connection, $profileQuery);
    if (!$profileResult) {
        die(mysqli_error($profileResult));
    }
    return $profileResult;
}

function getTahunMasuk($id_siswa){
    global $connection;
    $tahunMasukQuery = "SELECT tahun_masuk FROM siswa WHERE id = $id_siswa";
    $tahunMasukResult = mysqli_query($connection, $tahunMasukQuery);
    if (!$tahunMasukResult) {
        die(mysqli_error($tahunMasukResult));
    }
    return $tahunMasukResult;
}

function getMonth($month) {
    global $connection;
    $selectMonthIdQuery = "SELECT id, nama FROM bulan WHERE nama LIKE '$month%'";
    $selectMonthIdResult = mysqli_query($connection, $selectMonthIdQuery);
    if(!$selectMonthIdResult) {
        die(mysqli_error($selectMonthIdResult));
    }

    return $selectMonthIdResult;
}

function getPendingPayment($id_siswa) {
    global $connection;
    $selectPendingPaymentQuery = "SELECT * FROM pembayaran WHERE status = 'pending' AND id_siswa = $id_siswa";
    $selectPendingPaymentResult = mysqli_query($connection, $selectPendingPaymentQuery);
    if(!$selectPendingPaymentResult){
        die(mysqli_error($selectPendingPaymentResult));
    }

    return $selectPendingPaymentResult;
}

function toCurrency($value) {
    if ($value<0) return "-".toCurrency($value);
    return 'Rp' . number_format($value) . ',-';
}


?>