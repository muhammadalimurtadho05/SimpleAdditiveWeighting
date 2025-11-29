<?php
$alternatif = getAlternatif();
$kriteriaList = getKriteria();

if(isset($_POST['tambah'])){
    tambahAltDanSkor($_POST); 
    header("Location:index.php?page=Alternatif");
    exit;
}

if(isset($_GET['hapus'])){
    hapusAlternatif();
    header("Location:index.php?page=Alternatif");
    exit;
}

?>

<div class="top">
    <div class="kiri">
        <div class="page"><a href="index.php">Dashboard</a> / Alternatif</div>
        <h1>Alternatif</h1>
        <br>
        <a href="index.php?page=Alternatif&add" class="show">Tambah Alternatif Baru</a>
        
        <?php if(isset($_GET['add'])):?>
        <form action="" method="POST" class="frkamar">
            <label for="nama">Nama Alternatif</label>
            <input type="text" id="nama" name="alt" required>
            <?php foreach ($kriteriaList as $kriteria): ?>
            <div class="frkamar">
                <label for="skor_<?= $kriteria['ID_KRITERIA'] ?>"><?= $kriteria['KRITERIA'] ?></label>
                <input 
                    type="text" 
                    step="any" 
                    id="skor_<?= $kriteria['ID_KRITERIA'] ?>" 
                    name="skor[<?= $kriteria['ID_KRITERIA'] ?>]" 
                    required  <?= $kriteria['KRITERIA'] ?>
                ><br>
            </div>
            <?php endforeach; ?>
            
            <br>
            <button type="submit" class="btn-tambah" name="tambah">Tambah</button>
        </form>
        <?php endif?>
    </div>
    <div class="kanan">
        
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Alternatif</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($alternatif as $alt ):?>
        <tr>
            <td><?= $no?></td>
            <td>A<?= $no++?></td>
            <td><?= $alt['ALTERNATIF'] ?></td>
            <td>
                <a href="index.php?page=editA&id=<?= $alt['ID_ALTERNATIF'] ?>" class="show-edit">Edit</a>
                <a href="index.php?page=Alternatif&hapus&id=<?= $alt['ID_ALTERNATIF'] ?>" onclick="return confirm('Data Akan Dihapus?')" class="hps">Hapus</a>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
</table>