<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Заказы / Спецификации</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <div class="z">
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
        $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Itogovaya_stoim,Kontragent_IDkontragenta
 FROM zakaz";
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
 <th>ID заказа</td>
 <th>Номер</td>
 <th>Дата заказа</td>
 <th>Итоговая стоимость</td>
 <th>ID контрагента</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDzakaza']}</td>
 <td>{$row_data['Nomer']}</td>
 <td>{$row_data['Data_zakaza']}</td>
 <td>{$row_data['Itogovaya_stoim']}</td>
 <td>{$row_data['Kontragent_IDkontragenta']}</td>
 </tr>
EOM;
            }
            echo <<<EOTABLE
 </table>
EOTABLE;
            ?>
            </div>
            <?php
            $result->close();
        }
        $con->close();
        ?>
        <br>
        <br>
        <form align='left' action='../Search/search_zakaz.php' method='POST'>
            <font size='4'>Поиск заказа по номеру</font><br>
            <input type='text' name='sz' size='20'/><br><br>
            <font size='4'>Поиск оплаты по дате</font><br>
            <font size='4'>Начальный диапазон</font>
            <input type='date' name='so' size='20'/>
            <font size='4'>Конечный диапазон</font>
            <input type='date' name='so1' size='20'/>
            <input type='submit' value='Найти'/>
        </form>
        <button onclick="window.location.href='add_zakaz.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='update_zakaz.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='delete_zakaz.html'">Удалить</button>
    </div>

    <div class="spec">
        <?php
        include(__DIR__.'/../dbinfo.inc');
        $con1 = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
        if (mysqli_connect_errno() != 0) {
            $errno1 = mysqli_connect_errno();
            $errmsg1 = mysqli_connect_error();
            echo "Connect Failed with: ($errno1) $errmsg1<br/>\n";
            exit;
        }
        $con1->query("SET NAMES 'utf-8'");
        $query_str1 = "SELECT IDspecifikacii,Kolvo_tovara,Cena,Zakaz_IDzakaza,Komplect_Kod_komplect
 FROM specifikaciya";
        $result1 = $con1->query($query_str1);
        if ($result1 === FALSE) {
            $errno1 = $conn1->errno;
            $errmsg1 = $conn1->error;
            echo "Query Failed with: ($errno1) $errmsg1<br/>\n";
            $con1->close();
            exit;
        } else {
            ?>
            <div class="scroll"><?php
            echo <<<EOM
 <table border='0'>
 <tr>
 <th>ID</td>
 <th>Количество товара</td>
 <th>Цена</td>
 <th>ID заказа</td>
 <th>Код комплектующей</td>
 </tr>
EOM;
            while (($row_data1 = $result1->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data1['IDspecifikacii']}</td>
 <td>{$row_data1['Kolvo_tovara']}</td>
 <td>{$row_data1['Cena']}</td>
 <td>{$row_data1['Zakaz_IDzakaza']}</td>
 <td>{$row_data1['Komplect_Kod_komplect']}</td>
 </tr>
EOM;
            }
            echo <<<EOTABLE
 </table>
EOTABLE;
            ?>
            </div>
            <?php
            $result1->close();
        }
        $con1->close();
        ?>
        <br><br>
        <form align='left' action='../Search/search_spec.php' method='POST'>
            <br><br>
            <font size='4'>Поиск спецификаций по ID заказа:</font>
            <input type="text" name="si" size='10'>
            <input type='submit' value='Найти'/>
        </form>
        <button onclick="window.location.href='/../InsertHTML/add_spec.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_spec.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_spec.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
