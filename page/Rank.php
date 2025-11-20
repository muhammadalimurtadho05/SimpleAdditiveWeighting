<?php
$rank = getRanking();
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $rank = getRankingFill($_POST['fill']);
}
?>
<h1 class="fill">Ranking</h1>
<form action="" method="POST" class="fill">
    <input type="text" name="fill" value="<?=$_POST['fill']??'' ?>">
    <button type="submit">Filter</button>
</form>
<table>
    <thead>
        <th colspan="3">Ranking</th>
    </thead>
    <tbody>
        <?php $i=1; foreach( $rank as $normal ):?>
            <tr>
                <td><?= $i++?></td>
                <td><?= getAlternatifName($normal['ID_ALTERNATIF'])['ALTERNATIF'] ?></td>
                <td><?= $normal['normalize'] ?></td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>