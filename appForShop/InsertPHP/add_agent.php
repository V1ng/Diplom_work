<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidkontragent = isset($_POST['ID_kontragent']) ? intval($_POST['ID_kontragent']) : 0;
    $pnaimenovan = isset($_POST['Naimenovan']) ? $_POST['Naimenovan'] : '';
    $ptelephone = isset($_POST['Telephone']) ? $_POST['Telephone'] : '';
    $padress = isset($_POST['Adress']) ? $_POST['Adress'] : '';
    if
    ($pnaimenovan == '' or $ptelephone == '' or $padress == '' or $pidkontragent == 0) {
        throw new InvalidInputException();
    }
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'cp1251'");
    $query_str = "INSERT INTO kontragent(IDkontragenta,Naimenovan,Telephone,Adress)
 VALUES ('$pidkontragent','$pnaimenovan','$ptelephone','$padress')";
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
