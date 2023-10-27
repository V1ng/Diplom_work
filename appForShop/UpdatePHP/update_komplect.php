<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pkodkomplect = isset($_POST['Kod_komplect']) ? intval($_POST['Kod_komplect']) : 0;
    $pnaimen = isset($_POST['Naimen_komplect']) ? $_POST['Naimen_komplect'] : '';
    $pmodel = isset($_POST['Model']) ? $_POST['Model'] : '';
    $pproizvoditel = isset($_POST['Proizvoditel']) ? $_POST['Proizvoditel'] : '';
    $pvidk = isset($_POST['Vid_komplect_Kod_vida']) ? $_POST['Vid_komplect_Kod_vida'] : '';
    if
    ($pnaimen == '' or $pmodel == '' or $pproizvoditel == '' or $pvidk == '' or $pkodkomplect == 0) {
        throw new InvalidInputException();
    }
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "UPDATE komplect set
 Naimen_komplect='$pnaimen',
 Model='$pmodel',
 Proizvoditel='$pproizvoditel',
 Vid_komplect_Kod_vida='$pvidk'
 WHERE Kod_komplect=$pkodkomplect";
    $result = $con->query($query_str);
    if ($result) {
        header("Location: /../main.php");
    } else {
        echo "Error. UPDATE Failed with:
 ($con->errno) $con->error<br/>\n";
    };
    $con->close();
} else {
    header("Location: /../index.php");
}
?>
