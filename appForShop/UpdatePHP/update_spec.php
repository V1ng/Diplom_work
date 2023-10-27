<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidspec = isset($_POST['IDspecifikacii']) ? intval($_POST['IDspecifikacii']) : 0;
    $pkolvo = isset($_POST['Kolvo_tovara']) ? $_POST['Kolvo_tovara'] : '';
    $pcena = isset($_POST['Cena']) ? $_POST['Cena'] : '';
    $pidzakaz = isset($_POST['Zakaz_IDzakaza']) ? $_POST['Zakaz_IDzakaza'] : '';
    $pkodk = isset($_POST['Komplect_Kod_komplect']) ? $_POST['Komplect_Kod_komplect'] : '';
    if
    ($pkolvo == '' or $pcena == '' or $pidzakaz == '' or $pkodk == '' or $pidspec == 0) {
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
    $query_str = "UPDATE specifikaciya set
 Kolvo_tovara='$pkolvo',
 Cena='$pcena',
 Zakaz_IDzakaza=$pidzakaz,
 Komplect_Kod_komplect=$pkodk
 WHERE IDspecifikacii=$pidspec";
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
