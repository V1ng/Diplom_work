<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pkodvida = isset($_POST['Kod_vida']) ? intval($_POST['Kod_vida']) : 0;
    $pvid = isset($_POST['Vid_komplect']) ? $_POST['Vid_komplect'] : '';
    if
    ($pvid == '' or $pkodvida == 0) {
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
    $query_str = "INSERT INTO vid_komplect(Kod_vida,Vid_komplect)
 VALUES ('$pkodvida','$pvid')";
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
