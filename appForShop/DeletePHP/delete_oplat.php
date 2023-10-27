<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    include(__DIR__.'/../dbinfo.inc');
    $pidoplat = isset($_POST['IDoplat']) ? intval($_POST['IDoplat']) : 0;
    if ($pidoplat == 0) {
        throw new InvalidInputException();
    }
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $query_str = "DELETE FROM kniga_oplat WHERE IDoplat=$pidoplat";
    $result = $con->query($query_str);
    if ($result) {
        header("Location: /../main.php");
    } else {
        echo "Error. DELETE Failed with:
 ($con->errno) $con->error<br/>\n";
    };
    $con->close();
} else {
    header("Location: /../index.php");
}
?>
