<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Вид товаров</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    </style>
    <body>
    <div class="TT1">
        <?php
        include(__DIR__ . '/../dbinfo.inc');
        $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
        if (mysqli_connect_errno() != 0) {
            $errno = mysqli_connect_errno();
            $errmsg = mysqli_connect_error();
            echo "Connect Failed with: ($errno) $errmsg<br/>\n";
            exit;
        }
        $con->query("SET NAMES 'utf-8'");
        $query_str = "SELECT Kod_vida,Vid_komplect
 FROM vid_komplect";
        $result = $con->query($query_str);
        if ($result === FALSE) {
            $errno = $conn->errno;
            $errmsg = $conn->error;
            echo "Query Failed with: ($errno) $errmsg<br/>\n";
            $con->close();
            exit;
        } else {
            echo <<<EOM
 <table border='0'>
 <tr>
 <th>Код вида</td>
 <th>Вид комплектующей</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['Kod_vida']}</td>
 <td>{$row_data['Vid_komplect']}</td>
 </tr>
EOM;
            }
            echo <<<EOTABLE
 </table>
EOTABLE;
            // очистка набора данных
            $result->close();
        }
        //
        // освобождение соединения
        //
        $con->close();
        ?>
        <br>
        <button onclick="window.location.href='/../InsertHTML/add_vid.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_vid.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_vid.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
