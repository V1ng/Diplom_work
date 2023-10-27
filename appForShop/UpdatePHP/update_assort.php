<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidassort = isset($_POST['IDAssortiment']) ? intval($_POST['IDAssortiment']) : 0;
    $pkolvo = isset($_POST['Kolvo']) ? $_POST['Kolvo'] : '';
    $pcena = isset($_POST['Cena']) ? $_POST['Cena'] : '';
    $piddvij = isset($_POST['Kniga_dvij_IDdvij']) ? $_POST['Kniga_dvij_IDdvij'] : '';
    $pkodk = isset($_POST['Komplect_Kod_komplec']) ? $_POST['Komplect_Kod_komplec'] : '';
    if
    ($pkolvo == '' or $pcena == '' or $piddvij == '' or $pkodk == '' or $pidassort == 0) {
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
    $query_str = "UPDATE assortiment set
 Kolvo='$pkolvo',
 Cena='$pcena',
 Kniga_dvij_IDdvij=$piddvij,
 Komplect_Kod_komplec=$pkodk
 WHERE IDAssortiment=$pidassort";
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
