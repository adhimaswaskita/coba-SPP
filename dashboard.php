<?php include "includes/header.php" ?>
<?php include "includes/functions.php" ?>

<?php 

$result = getCardInfo();

$arrearsResult = getUserArrears();
$arrearsData = mysqli_fetch_assoc($arrearsResult);
$arrears = $arrearsData['SUM(bulan.nominal)'];
$userArrears = toCurrency($arrears);

$profileResult = getProfileInfo();
$tahunMasukResult = getTahunMasuk();

?>

<div class="profile">
    <?php while ($profileData = mysqli_fetch_assoc($profileResult)) { 
        $firstName =  explode(" ",$profileData['name']); ?>
        <img src="<?php echo $profileData['photo'] ?>" alt="" class="profile-picture">
        <h1 class="profile-title">Halo, <br> <?php echo $firstName[0] ?></h1>
        <h2 class="profile-information-title" style="margin-top:40px">Tahun Masuk</h2>
        <p class="profile-information"><?php echo $profileData['tahun_masuk'] ?></p>
        <hr class="separator">
        <h2 class="profile-information-title">Kelas</h2>
        <p class="profile-information"><?php echo $profileData['kelas'] ?></p>
        <hr class="separator">
        <h2 class="profile-information-title">NIS</h2>
        <p class="profile-information"><?php echo $profileData['NIS'] ?></p>
        <?php
    } ?>
</div>

<div class="head-container">
    <img src="./assets/images/tunggakan.svg" alt="">
    <h1 class="head-title">Total tunggakan</h1>
    <h1 class="head-content"><?php echo $userArrears?></h1>
</div>

<div class="months-container">
    <form action="bayar.php" method="post">
        <select name="years" id="tahun">
            <?php while ($tahunPelajaran = mysqli_fetch_assoc($tahunMasukResult)) { 
                $intTahunMasuk = (int)$tahunPelajaran['tahun_masuk']
            ?>
            <option value="<?php echo (($intTahunMasuk) . "-" . ($intTahunMasuk +1));?>"><?php echo (($intTahunMasuk) . "-" . ($intTahunMasuk +1));  ?></option>
            <option value="<?php echo (($intTahunMasuk+1) . "-" . ($intTahunMasuk +2));?>"><?php echo (($intTahunMasuk+1) . "-" . ($intTahunMasuk +2));?></option>
            <option value="<?php echo (($intTahunMasuk+2) . "-" . ($intTahunMasuk +3));?>"><?php echo (($intTahunMasuk+2) . "-" . ($intTahunMasuk +3));?></option>
            <?php 
            }
            ?>
        </select>
        <h2 class="months-container-title">Status SPP</h2>
            <?php 
                while ($data = mysqli_fetch_assoc($result)) { ?>
                    <?php 
                        if($data['id'] == 7){
                            echo "<br>";
                        }
                        if ($data['id'] <= date('n')) {
                            if ($data['status']  == NULL ) {
                                ?>
                                    <div class="months-warning">
                                        <div class="checklist">
                                            <h1>!</h1>
                                        </div>
                                        <input type="submit" name="submit" class="month-name" value="<?php echo $data['nama'][0] . $data['nama'][1] . $data['nama'][2]; ?>" >                    
                                    </div>
                                <?php
                            }
                            else if ($data['status']  == 'pending' ) {
                                ?>
                                    <div class="months-pending">
                                        <div class="checklist">
                                            <h1><img src="./assets/images/clock-black.svg" alt="clock-icon" class="months-container-image"></h1>
                                        </div>
                                        <input type="submit" name="submit" class= "month-name" value="<?php echo $data['nama'][0] . $data['nama'][1] . $data['nama'][2]; ?>" >                    
                                    </div>
                                <?php
                            }
                            else  {
                                ?>
                                    <div class="months-success">
                                        <div class="checklist">
                                            <h1><img src="./assets/images/tick-black.svg" alt="checkmark-icon" class="months-container-image"></h1>
                                        </div>
                                        <input type="submit" name="submit" class="month-name" value="<?php echo $data['nama'][0] . $data['nama'][1] . $data['nama'][2]; ?>" disabled="disabled">                    
                                    </div>
                                <?php
                            }
                        } 
                        else {
                            if ($data['status']  == NULL ) {
                                ?>
                                    <div class="months">
                                        <div class="checklist">
                                            <h1></h1>
                                        </div>
                                        <input type="submit" name="submit" class="month-name" value="<?php echo $data['nama'][0] . $data['nama'][1] . $data['nama'][2]; ?>" disabled="disabled" >                    
                                    </div>
                                <?php
                            } 
                            else  {
                                ?>
                                    <div class="months-success">
                                        <div class="checklist">
                                            <h1><img src="./assets/images/tick-black.svg" alt="checkmark-icon" class="months-container-image"></h1>
                                        </div>
                                        <input type="submit" name="submit" class="month-name" value="<?php echo $data['nama'][0] . $data['nama'][1] . $data['nama'][2]; ?>" disabled="disabled">                    
                                    </div>
                                <?php
                            }
                        }
                    ?>

                <?php } 
            ?>
        </form>
</div>

<?php include "includes/footer.php" ?>
