<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidzakaza = isset($_POST['IDzakaza']) ? intval($_POST['IDzakaza']) : 0;
    $pnomer = isset($_POST['Nomer']) ? $_POST['Nomer'] : '';
    $pdatazakaza = isset($_POST['Data_zakaza']) ? $_POST['Data_zakaza'] : '';
    $pitog = isset($_POST['Itogovaya_stoim']) ? $_POST['Itogovaya_stoim'] : '';
    $pidkontragent = isset($_POST['Kontragent_IDkontragenta']) ? intval($_POST['Kontragent_IDkontragenta']) : 0;
    if ($pnomer == '' or $pdatazakaza == '' or $pitog = '' or $pidzakaza == 0 or $pidkontragent == 0) {
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
    $query_str = "UPDATE zakaz set
 Nomer='$pnomer',
 Data_zakaza='$pdatazakaza',
 Itogovaya_stoim=$pitog
 Kontragent_IDkontragenta=$pidkontragent
 WHERE IDzakaza=$pidzakaza";
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
