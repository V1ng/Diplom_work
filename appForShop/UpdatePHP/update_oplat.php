<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidoplat = isset($_POST['IDoplat']) ? intval($_POST['IDoplat']) : 0;
    $psymma = isset($_POST['Symma_oplat']) ? $_POST['Symma_oplat'] : '';
    $psposob = isset($_POST['Sposob_oplat']) ? $_POST['Sposob_oplat'] : '';
    $pdata = isset($_POST['Data_oplat']) ? $_POST['Data_oplat'] : '';
    $pidzakaz = isset($_POST['Zakaz_IDzakaza']) ? $_POST['Zakaz_IDzakaza'] : '';
    if
    ($psymma == '' or $psposob == '' or $pdata == '' or $pidzakaz == '' or $pidoplat == 0) {
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
    $query_str = "UPDATE kniga_oplat set
 Symma_oplat='$psymma',
 Sposob_oplat='$psposob',
 Data_oplat='$pdata',
 Zakaz_IDzakaza=$pidzakaz
 WHERE IDoplat=$pidoplat";
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
