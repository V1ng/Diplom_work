<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidostat = isset($_POST['IDostatka']) ? intval($_POST['IDostatka']) : 0;
    $pkolvo = isset($_POST['Kolvo']) ? $_POST['Kolvo'] : '';
    $pcena = isset($_POST['Cena']) ? $_POST['Cena'] : '';
    $pkodkomplect = isset($_POST['Komplect_Kod_komplect']) ? $_POST['Komplect_Kod_komplect'] : '';
    if
    ($pkolvo == '' or $pcena == '' or $pkodkomplect == '' or $pidostat == 0) {
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
    $query_str = "UPDATE skladskie_ostatki set
 Kolvo='$pkolvo',
 Cena='$pcena',
 Komplect_Kod_komplect='$pkodkomplect'
 WHERE IDostatka=$pidostat";
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
