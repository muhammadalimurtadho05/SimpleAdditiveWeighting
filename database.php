<?php
function getKriteria(){
    $kriteria = DBC->prepare("SELECT * FROM kriteria ORDER BY ID_KRITERIA ASC");
    $kriteria->execute();
    return $kriteria->fetchAll();
}
// function getKriteria2(){
//     $kriteria = DBC->prepare("SELECT * FROM kriteria ORDER BY ID_KRITERIA ASC");
//     $kriteria->execute();
//     return $kriteria->fetchAll(PDO::FETCH_NUM);
// }
function getjumlahKriteria(){
    $kriteria = DBC->prepare("SELECT count(*) AS jumlah FROM kriteria");
    $kriteria->execute();
    return $kriteria->fetch();
}

function getSkor(){
    $skor = DBC->prepare("
        SELECT
        alternatif.ID_ALTERNATIF AS A_ID_ALTERNATIF,
        alternatif.ALTERNATIF AS NAMA,

        skor.ID_KRITERIA AS S_ID_KRITERIA,
        skor.SKOR AS S_SKOR,

        kriteria.ID_KRITERIA AS K_ID_KRITERIA,
        kriteria.KRITERIA AS K_NAMA_KRITERIA
    FROM alternatif
    LEFT JOIN skor ON skor.ID_ALTERNATIF = alternatif.ID_ALTERNATIF
    LEFT JOIN kriteria ON skor.ID_KRITERIA = kriteria.ID_KRITERIA
    ORDER BY alternatif.ID_ALTERNATIF, kriteria.ID_KRITERIA
    ");
    $skor->execute();
    $data = $skor->fetchAll();
    $temp = [];
    foreach($data as $dt){
        if(!isset($temp[$dt['A_ID_ALTERNATIF']])){
            $temp[$dt['A_ID_ALTERNATIF']][] = [
                'ID_KRITERIA' => $dt['S_ID_KRITERIA'],
                'SKOR' => $dt['S_SKOR']
            ];
        }else{
            $temp[$dt['A_ID_ALTERNATIF']][] = [
                'ID_KRITERIA' => $dt['S_ID_KRITERIA'],
                'SKOR' => $dt['S_SKOR']
            ];
        }
    }
    return $temp;
}

function tambahKriteria($array){
    $tambah = DBC->prepare("INSERT INTO kriteria VALUES (:id, :nama,:bobot)");
    $tambah->execute([
        ':id'=>null,
        ':nama' => $array['kriteria'],
        ':bobot' => $array['bobot']
    ]);
    header('Location:index.php?page=Kriteria');
    die;
}

function tambahAltDanSkor($array){
    $db = DBC->prepare('INSERT INTO alternatif (ALTERNATIF) VALUES(:alt)');
    $db->execute([':alt' => $array['alt']]);
    $id_alt_baru = DBC->lastInsertId();
    if (isset($array['skor']) && is_array($array['skor'])) {
        foreach ($array['skor'] as $id_kriteria => $nilai_skor) {
            if (is_numeric($id_kriteria) && is_numeric($nilai_skor)) {
                $ins = DBC->prepare("INSERT INTO skor (ID_ALTERNATIF, ID_KRITERIA, SKOR) VALUES (:id_alt, :id_kt, :sk)");
                $ins->execute([
                    ':id_alt' => $id_alt_baru,
                    ':id_kt' => $id_kriteria,
                ]);
            }
        }
    }
}

function getAlternatif(){
    $alt = DBC->prepare("SELECT * FROM alternatif");
    $alt->execute();
    return $alt->fetchAll();
}
function getAlternatifName($id= 0){
    $alt = DBC->prepare("SELECT * FROM alternatif WHERE ID_ALTERNATIF = :id");
    if(isset($_GET['id'])){
        $alt->execute([':id'=>$_GET['id']]);
    }else{
        $alt->execute([':id'=>$id]);

    }
    return $alt->fetch(); 
}
function getSkorAlt(){
    $skor = DBC->prepare("SELECT kriteria.*, skor.* FROM kriteria LEFT JOIN skor ON kriteria.ID_KRITERIA = skor.ID_KRITERIA AND skor.ID_ALTERNATIF = :id ORDER BY kriteria.ID_KRITERIA ASC");
    $skor->execute([':id' => $_GET['id']]);
    return $skor->fetchAll();
}

function cek_skor($id_alt,$id_kt ){
    $alt = DBC->prepare("SELECT * FROM skor WHERE ID_ALTERNATIF = :id_alt AND ID_KRITERIA = :id_kt");
    $alt->execute([':id_alt'=>$id_alt,':id_kt'=>$id_kt]);
    return $alt->rowCount();
}

function updateSkor($array){
    $kriteria = getKriteria();
    $id_alt = $_GET['id'];
    $upNama = DBC->prepare("UPDATE alternatif SET ALTERNATIF = :alt WHERE ID_ALTERNATIF = :id");
    $upNama->execute([':alt' => $_POST['nama'],':id'=>$id_alt]);
    $ind = 0;
    $skor = $array['skor'];
    foreach ($kriteria as $kt){
        echo $skor[$ind];
        echo "<br>";
        if(cek_skor($id_alt,$kt['ID_KRITERIA'])<1){
            echo "ga nemu";
            echo "<br>";

            $ins = DBC->prepare("INSERT INTO skor VALUES (null, :id_alt, :id_kt, :sk)");
            $ins->execute([
                ':id_alt' => $id_alt,
                ':id_kt' => $kt['ID_KRITERIA'],
                ':sk'=>$skor[$ind]
            ]);
        }else{
            echo "nemu";
            echo "<br>";
            $up = DBC->prepare("UPDATE skor SET SKOR = :skor WHERE ID_ALTERNATIF = :id_alt AND ID_KRITERIA = :id_kt");
            $up->execute([
                ':id_alt' => $id_alt,
                ':id_kt' => $kt['ID_KRITERIA'],
                ':skor'=>$skor[$ind]
            ]);
        }
        $ind++;
    }
}

function tambahAlt($array){
    $db = DBC->prepare('INSERT INTO alternatif VALUES(NULL, :alt)');
    $db->execute([':alt'=>$array['alt']]);
}

function getKriteriaName(){
 $db = DBC->prepare("SELECT * FROM kriteria WHERE ID_KRITERIA = :id");
 $db->execute([':id'=>$_GET['id']]);
 return $db->fetch();
}

function editKriteria($array){
    $dt = DBC->prepare("UPDATE kriteria SET KRITERIA = :ktt, BOBOT = :bobot WHERE ID_KRITERIA = :id");
    $dt->execute([
        ':ktt' => $array['ktt'],
        ':bobot' =>$array['bobot'],
        ':id' => $array['id']
    ]);
}

function hapusKriteria(){
    $db = DBC->prepare("DELETE FROM kriteria WHERE ID_KRITERIA = :id");
    $db->execute(['id'=>$_GET['id']]);
}
function hapusAlternatif(){
    $db = DBC->prepare("DELETE FROM alternatif WHERE ID_ALTERNATIF = :id");
    $db->execute(['id'=>$_GET['id']]);
}
function getMaks(){
    $db = DBC->prepare("SELECT kriteria.*, MAX(skor.SKOR) AS MAKS FROM kriteria LEFT JOIN skor ON kriteria.ID_KRITERIA = skor.ID_KRITERIA GROUP BY kriteria.ID_KRITERIA ORDER BY kriteria.ID_KRITERIA ASC");
    $db->execute();
    return $db->fetchAll();
}
function normalize(){
    $db=DBC->prepare("SELECT 
    s.ID_ALTERNATIF,
    SUM( (s.SKOR / m.max_skor) * k.BOBOT ) AS normalize
    FROM skor s
    JOIN kriteria k ON s.ID_KRITERIA = k.ID_KRITERIA
    JOIN (
        SELECT ID_KRITERIA, MAX(SKOR) AS max_skor
        FROM skor
        GROUP BY ID_KRITERIA
    ) m ON s.ID_KRITERIA = m.ID_KRITERIA
    GROUP BY s.ID_ALTERNATIF
    ORDER BY s.ID_ALTERNATIF;
    ");
    $db->execute();
    return $db->fetchAll();

}
function getRanking(){

    $db=DBC->prepare("SELECT 
    s.ID_ALTERNATIF,
    SUM( (s.SKOR / m.max_skor) * k.BOBOT ) AS normalize
    FROM skor s
    JOIN kriteria k ON s.ID_KRITERIA = k.ID_KRITERIA
    JOIN (
        SELECT ID_KRITERIA, MAX(SKOR) AS max_skor
        FROM skor
        GROUP BY ID_KRITERIA
    ) m ON s.ID_KRITERIA = m.ID_KRITERIA
    GROUP BY s.ID_ALTERNATIF
    ORDER BY normalize DESC;
    ");
    $db->execute();
    return $db->fetchAll();
}
function getRankingFill($limit){

    $db=DBC->prepare("SELECT 
    s.ID_ALTERNATIF,
    SUM( (s.SKOR / m.max_skor) * k.BOBOT ) AS normalize
    FROM skor s
    JOIN kriteria k ON s.ID_KRITERIA = k.ID_KRITERIA
    JOIN (
        SELECT ID_KRITERIA, MAX(SKOR) AS max_skor
        FROM skor
        GROUP BY ID_KRITERIA
    ) m ON s.ID_KRITERIA = m.ID_KRITERIA
    GROUP BY s.ID_ALTERNATIF
    ORDER BY normalize DESC LIMIT $limit;
    ");
    $db->execute();
    return $db->fetchAll();
}

