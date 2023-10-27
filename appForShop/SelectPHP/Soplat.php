<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Книга оплат</title>
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
        $query_str = "SELECT IDoplat,Symma_oplat,Sposob_oplat,Data_oplat,Zakaz_IDzakaza
 FROM kniga_oplat";
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
 <th>Сумма оплат</td>
 <th>Способ оплат</td>
 <th>Дата оплаты</td>
 <th>ID заказа</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDoplat']}</td>
 <td>{$row_data['Symma_oplat']}</td>
 <td>{$row_data['Sposob_oplat']}</td>
 <td>{$row_data['Data_oplat']}</td>
 <td>{$row_data['Zakaz_IDzakaza']}</td>
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
        <form align='left' action='../Search/search_oplat.php' method='POST'>
            <font size='4'>Поиск оплаты по дате</font><br>
            <font size='4'>Начальный диапазон</font>
            <input type='date' name='so' size='20'/>
            <font size='4'>Конечный диапазон</font>
            <input type='date' name='so1' size='20'/>
            <input type='submit' value='Найти'/>
        </form>
        <button onclick="window.location.href='/../InsertHTML/add_oplat.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_oplat.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_oplat.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
