<?php
$all = getKriteria();
$total_bobot = 0;
foreach($all as $kt) {
    $total_bobot += (float)$kt['BOBOT'];
}

if(isset($_POST['tambah'])){
    tambahKriteria($_POST);
}
if(isset($_POST['edit'])){
     editKriteria($_POST);
     header("Location:index.php?page=Kriteria");
}
if(isset($_GET['hapus'])){
     hapusKriteria();
     header("Location:index.php?page=Kriteria");
}
?>
<div class="top">
     <div class="kiri">
         <div class="page"><a href="index.php">Dashboard</a> / Kriteria</div>
         <h1>Daftar Kriteria</h1><br>
     </div>
     <div class="kanan">
        <?php if(isset($_SESSION['msg_sc'])):?>
         <div class="kanan">
            <span class="success-alert"><?= $_SESSION['msg_sc']?> </span>
         </div>
         <?php
         unset($_SESSION['msg_sc']);
         ?>
     <?php endif?>
     <?php if(isset($_SESSION['msg_err'])):?>
         <div class="kanan">
         <?php
         ?>
         <?php foreach($_SESSION['msg_err'] as $err ):?>
            <div class="danger-alert"><?=$err?></div>
         <?php endforeach?>
         </div>
         <?php
         unset($_SESSION['msg_err']);
         ?>
     <?php endif?>
         <?php if(isset($_GET['edit'])):?>
            <?php
            $ktt = getKriteriaName();
            ?>
         <form action="" method="POST" class="frkamar editjurusan">
            <label for="nama">Nama Kriteria</label>
            <input type="hidden" name="id" value="<?= $ktt['ID_KRITERIA'] ?>">
            <input type="text" id="ktt" value="<?= $ktt['KRITERIA'] ?>" name="ktt"><br>
            <label for="kapasitas">Bobot</label>
            <input type="text" id="kapasitas" name="bobot" value="<?=$ktt['BOBOT'] ?>"><br>
            <div class="btn">
              <button type="submit" class="btn-tambah" name="edit">Edit</button>
            </div>
         </form>
         <?php endif?>
     </div>
</div>
<a href="index.php?page=Kriteria&add" class="show">Tambah Kriteria Baru</a>
<?php if(isset($_GET['add'])):?>
<form action="" method="POST" class="frkamar">
     <label for="nama">Nama Kriteria</label>
     <input type="text" id="nama" name="kriteria"><br>
     <label for="bobot">Bobot</label>
     <input type="number" id="bobot" step="0.01" name="bobot"><br>
     <button type="submit" class="btn-tambah" name="tambah">Tambah</button>
</form>
<?php endif?>
<table>
     <thead>
         <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kriteria</th>
            <th>Bobot</th>
            <th>Aksi</th>
         </tr>
     </thead>
     <tbody>
         <?php $no = 1; foreach($all as $kt ):?>
         <tr>
            <td><?= $no?></td>
            <td>C<?= $no++?></td>
            <td><?= $kt['KRITERIA'] ?></td>
            <td><?= $kt['BOBOT'] ?></td>
                <td>
              <a href="index.php?page=Kriteria&edit&id=<?= $kt['ID_KRITERIA'] ?>" class="show-edit">Edit</a>
              <a href="index.php?page=Kriteria&hapus&id=<?= $kt['ID_KRITERIA'] ?>" onclick="return confirm('Data Akan Dihapus?')" class="hps">Hapus</a>
            </td>
         </tr>
         <?php endforeach?>
     </tbody>
     <tfoot>
         <tr>
            <td colspan="3">Total Persentase Bobot:</td>   
            <td>
              <?= number_format($total_bobot * 100) ?>%
            </td>
            <td></td> </tr>
     </tfoot>
</table>