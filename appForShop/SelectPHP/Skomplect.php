<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Товары</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <div class="TT">
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
        $query_str = "SELECT Kod_komplect,Naimen_komplect,Model,Proizvoditel,Vid_komplect_Kod_vida
 FROM komplect";
        $result = $con->query($query_str);
        if ($result === FALSE) {
            $errno = $conn->errno;
            $errmsg = $conn->error;
            echo "Query Failed with: ($errno) $errmsg<br/>\n";
            $con->close();
            exit;
        } else {
            ?>
            <div class="scroll"><?php
            echo <<<EOM
 <table border='0'>
 <tr>
 <th>Код</td>
 <th>Наименование</td>
 <th>Модель</td>
 <th>Производитель</td>
 <th>Вид комплектующей</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['Kod_komplect']}</td>
 <td>{$row_data['Naimen_komplect']}</td>
 <td>{$row_data['Model']}</td>
 <td>{$row_data['Proizvoditel']}</td>
 <td>{$row_data['Vid_komplect_Kod_vida']}</td>
 </tr>
EOM;
            }
            echo <<<EOTABLE
 </table>
EOTABLE;
            ?>
            </div>
            <?php
            // очистка набора данных
            $result->close();
        }
        //
        // освобождение соединения
        //
        $con->close();
        ?>
        <br><br>
        <form align='left' action='../Search/search_komplect.php' method='POST'>
            <font size='4'>Поиск комплектующих по наименованию:</font>
            <input type="text" name="sk" size='40'><br>
            <font size='4'>Поиск комплектующих по производителю:</font>
            <input type="text" name="sp" size='40'>
            <input type='submit' value='Найти'/>
        </form>
        <button onclick="window.location.href='/../InsertHTML/add_komplect.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_komplect.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_komplect.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
