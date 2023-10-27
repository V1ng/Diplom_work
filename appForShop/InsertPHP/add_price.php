<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidprice = isset($_POST['IDPrice']) ? intval($_POST['IDPrice']) : 0;
    $pcena = isset($_POST['Cena']) ? $_POST['Cena'] : '';
    $pdata = isset($_POST['Data']) ? $_POST['Data'] : '';
    $pkodk = isset($_POST['Komplect_Kod_komplect']) ? $_POST['Komplect_Kod_komplect'] : '';
    if
    ($pcena == '' or $pdata == '' or $pkodk == '' or $pidprice == 0) {
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
    $query_str = "INSERT INTO price(IDPrice,Cena,Data,Komplect_Kod_komplect)
 VALUES ('$pidprice','$pcena','$pdata',$pkodk)";
    $result = $con->query($query_str);
    if ($result) {
        header("Location: /../main.php");
    } else {
        echo "Error. INSERT Failed with:
 ($con->errno) $con->error<br/>\n";
    };
    $con->close();
} else {
    header("Location: /../index.php");
}
?>
