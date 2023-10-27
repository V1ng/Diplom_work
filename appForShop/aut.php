<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if ($_POST['Submit']) {
    $dbuser = isset($_POST['login']) ? $_POST['login'] : '';
    $dbpasswd = isset($_POST['password']) ? $_POST['password'] : '';
    $dblocation = "localhost";
    $dbname = "shop";
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    } else {
        $_SESSION['logged_user'] = $_POST['login'];
        $_SESSION['logged_pass'] = $_POST['password'];
        header("Location: main.php");
        $con->close();
        exit;
    }
}
?>
<html>
<body>
Вы ввели неверные данные!
</body>
</html>
