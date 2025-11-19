<?php
$jumlahKriteria = getjumlahKriteria();
$skor = getSkor();
$maksSkor = getMaks();
?>
<h1>Matriks</h1>
<table>
    <thead>
        <tr>
            <th rowspan="2">Alternatif</th>
            <th colspan="<?= $jumlahKriteria['jumlah']?>"> Kriteria</th>
        </tr>
        <tr>
            <?php
            for($i = 1;$i<=$jumlahKriteria['jumlah'];$i++){
            ?>
            <th>C<?= $i?></th>
            <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($skor as $s ):?>
        <tr>
            <td>A<?= $no++?></td>
            <?php foreach($s as $st ):?>
                <td><?= $st['SKOR'] ?></td>
            <?php endforeach?>
        </tr>
        <?php endforeach?>
    </tbody>
    <tfoot>
        <tr>
            <th>Max</th>
        <?php foreach( $maksSkor as $maks ):?>
            <th><?= $maks['MAKS']?></th>
        <?php endforeach?>
            </tr>
    </tfoot>
</table>
<br>
<hr>
<h1>Matriks Ternormalisasi</h1>
<table>
    <thead>
        <tr>
            <th rowspan="2">Alternatif</th>
            <th colspan="<?= $jumlahKriteria['jumlah']?>"> Kriteria</th>
        </tr>
        <tr>
            <?php
            for($i = 1;$i<=$jumlahKriteria['jumlah'];$i++){
            ?>
            <th>C<?= $i?></th>
            <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        
        ?>
        <?php $no=1; foreach($skor as $s ):?>
            <?php
            $ind = 0;
            ?>
        <tr>
            <td>A<?= $no++?></td>
            <?php foreach($s as $st ):?>
                <td><?= number_format($st['SKOR'] / $maksSkor[$ind]['MAKS'],3) ?></td>
                <?php
                $ind++;
        ?>
            <?php endforeach?>
        </tr>
        
        <?php endforeach?>
    </tbody>
</table>