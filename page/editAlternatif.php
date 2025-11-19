<?php
$altName = getAlternatifName();
$skor = getSkorAlt();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    updateSkor($_POST);
    header("Location:index.php?page=editA&id={$_GET['id']}");
}
?>
<div class="profile-card">
    <h1><?= $altName['ALTERNATIF'] ?></h1>
    <form action="" method="POST">
        <div class="profile-info">
            <div>
                <strong>Nama Alternatif</strong>
                <span>
                    <input type="text" required name="nama" class="profile-form"  value="<?= $altName['ALTERNATIF'] ?>"><br>
                </span>
            </div>
            <br>
            <h1 style="text-align: center;">Skor</h1>
            <br>
            <?php foreach($skor as $s ):?>
                <div>
                    <strong><?= $s['KRITERIA'] ?></strong>
                    <span class="knn">
                        <input type="text" name="skor[]" required value="<?=($s['SKOR'] == null ? 0 : $s['SKOR']) ?>" class="profile-form"><br>
                    </span>
                </div>
            <?php endforeach?>
            <div>
                    <a href="index.php?page=Alternatif" style="display:inline-block;width:80px; text-align:center;" class="show">Kembali</a>
                    <button class="btn-tambah" type="submit">Update!</button>
            </div>
        </div>
    </form>
</div>  
