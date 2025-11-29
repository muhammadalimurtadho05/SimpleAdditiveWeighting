<?php
session_start();
require_once 'conn.php';
define('APP_SECURE', true);
require_once 'database.php';
require_once 'Components/header.php';
if (isset($_SESSION['pesan'])) {
    $tipe = $_SESSION['pesan']['tipe'] ?? 'info';
    $teks = $_SESSION['pesan']['teks'] ?? '';

    echo "<div class='alert-message {$tipe}'>{$teks}</div>";
    unset($_SESSION['pesan']);
}
?>

<?php
if(isset($_GET['page'])){
    $page = $_GET['page'];
    if($page == 'Kriteria'){
        require_once 'page/Kriteria.php';
    }else if($page == 'Alternatif'){
        require_once 'page/Alternatif.php';
    }else if($page == 'Matriks'){
        require_once 'page/matriks.php';
    }else if($page == 'editK'){
        require_once 'page/editKriteria.php';
    }
    else if($page == 'editA'){
        require_once 'page/editAlternatif.php';
    }
    else if($page == 'Rank'){
        require_once 'page/Rank.php';
    }
    else{
        require_once 'page/404.php';
    }
}else{
    include 'page/dashboard.php';
}
?>
<?php
require_once 'Components/footer.php';

?>
   