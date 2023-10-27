<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $piddvij = isset($_POST['IDdvij']) ? intval($_POST['IDdvij']) : 0;
    $pnomerdoc = isset($_POST['Nomer_doc']) ? $_POST['Nomer_doc'] : '';
    $pkodoper = isset($_POST['Kod_oper']) ? $_POST['Kod_oper'] : '';
    $pdata = isset($_POST['Data']) ? $_POST['Data'] : '';
    $pobch = isset($_POST['Obchaya_stoim']) ? $_POST['Obchaya_stoim'] : '';
    $pidkontr = isset($_POST['Kontragent_IDkontragenta']) ? $_POST['Kontragent_IDkontragenta'] : '';
    $pidzakaz = isset($_POST['Zakaz_IDzakaza']) ? $_POST['Zakaz_IDzakaza'] : '';
    if
    ($pnomerdoc == '' or $pkodoper == '' or $pdata == '' or $pobch == '' or $pidkontr == '' or $pidzakaz == '' or $piddvij == 0) {
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
    $query_str = "UPDATE kniga_dvij set
 Nomer_doc='$pnomerdoc',
 Kod_oper='$pkodoper',
 Data='$pdata',
 Obchaya_stoim='$pobch',
 Kontragent_IDkontragenta=$pidkontr,
 Zakaz_IDzakaza=$pidzakaz
 WHERE IDdvij=$piddvij";
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
