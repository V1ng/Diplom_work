<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Остатки на складе</title>
        <link rel="stylesheet" href="../style.css">
    </head>
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
        $query_str = "SELECT IDostatka,Kolvo,Cena,Komplect_Kod_komplect
 FROM skladskie_ostatki";
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
 <th>ID</td>
 <th>Количество</td>
 <th>Цена</td>
 <th>Код комплектующей</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDostatka']}</td>
 <td>{$row_data['Kolvo']}</td>
 <td>{$row_data['Cena']}</td>
 <td>{$row_data['Komplect_Kod_komplect']}</td>
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
        <form align='left' action='../Report/reportost.php' method='POST'>
            <font size='4'>Отчет по остаткам на складе</font><br>
            <input type='submit' value='Сформировать отчет'/>
        </form>
        <br>
        <button onclick="window.location.href='/../InsertHTML/add_ostat.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_ostat.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_ostat.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
