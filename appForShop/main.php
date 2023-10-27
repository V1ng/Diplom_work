<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Интернет-магазин</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <div class="block1">
        <?php
        include('dbinfo.inc');
        $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
        if (mysqli_connect_errno() != 0) {
            $errno = mysqli_connect_errno();
            $errmsg = mysqli_connect_error();
            echo "Connect Failed with: ($errno) $errmsg<br/>\n";
            exit;
        }
        $con->query("SET NAMES 'utf-8'");
        $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Itogovaya_stoim,Naimenovan
 FROM Zakaz_v Order BY IDzakaza";
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
 <table border=1>
 <tr>
 <th>ID заказа</td>
 <th>Номер</td>
 <th>Дата заказа</td>
 <th>Итоговая стоимость</td>
 <th>Наименование агента</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDzakaza']}</td>
 <td>{$row_data['Nomer']}</td>
 <td>{$row_data['Data_zakaza']}</td>
 <td>{$row_data['Itogovaya_stoim']}</td>
 <td>{$row_data['Naimenovan']}</td>
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
        <form align='left' action='Report/report.php' method='POST'>
            <font size='4'>Отчет по заказам</font><br>
            <font size='4'>С даты</font>
            <input type='date' name='so' size='20'/>
            <font size='4'>По дату</font>
            <input type='date' name='so1' size='20'/>
            <input type='submit' value='Сформировать отчет'/>
        </form>
    </div>
    <div class="esc">
        <button name='esc'><a href="aut.php?logout">Выйти из приложения</a></button>
        <br><br>
    </div>
    <div class="block2">
        <br>
        <table>
            <th>Информация о контрагентах</th>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Sagent.php'">Контрагент</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="block3">
        <table>
            <th>Информация о заказах</th>
            <tr>
                <td>
                    <button width=100px onclick="window.location.href='SelectPHP/Szakaz.php'">Заказы</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Sdvij.php'">Книга движения</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="block4">
        <table>
            <th>Информация о товарах</th>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Skomplect.php'">Комплектующие</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Svid.php'">Вид комплектующих</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Sprice.php'">Прайс комплектующих</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Sostat.php'">Складские остатки</button>
                </th></tr>
        </table>
    </div>
    <div class="block5">
        <table>
            <th>Информация об оплатах</th>
            <tr>
                <td>
                    <button onclick="window.location.href='SelectPHP/Soplat.php'">Книга оплат</button>
                </td>
            </tr>
        </table>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: index.php");
}
?>
