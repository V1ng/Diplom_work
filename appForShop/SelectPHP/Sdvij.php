<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Книга движения / Ассортимент</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <div class="dv">
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
        $query_str = "SELECT IDdvij,Nomer_doc,Kod_oper,Data,Obchaya_stoim,Kontragent_IDkontragenta,Zakaz_IDzakaza
 FROM kniga_dvij";
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
 <th>Номер <br>документа</td>
 <th>Код операции</td>
 <th>Дата</td>
 <th>Общая стоимость</td>
 <th>ID <br>контрагента</td>
 <th>ID заказа</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDdvij']}</td>
 <td>{$row_data['Nomer_doc']}</td>
 <td>{$row_data['Kod_oper']}</td>
 <td>{$row_data['Data']}</td>
 <td>{$row_data['Obchaya_stoim']}</td>
 <td>{$row_data['Kontragent_IDkontragenta']}</td>
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
        <form align='left' action='../Search/search_dvij.php' method='POST'>
            <font size='4'>Поиск документа по номеру:</font>
            <input type="text" name="sn" size='40'>
            <input type='submit' value='Найти'/>
        </form>
        <br>
        <button onclick="window.location.href='/../InsertHTML/add_dvij.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_dvij.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_dvij.html'">Удалить</button>
    </div>
    <div class="as">
        <?php
        include(__DIR__.'/../dbinfo.inc');
        $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
        if (mysqli_connect_errno() != 0) {
            $errno = mysqli_connect_errno();
            $errmsg = mysqli_connect_error();
            echo "Connect Failed with: ($errno) $errmsg<br/>\n";
            exit;
        }
        $con->query("SET NAMES 'utf-8'");
        $query_str = "SELECT IDAssortiment,Kolvo,Cena,Kniga_dvij_IDdvij,Komplect_Kod_komplec
 FROM assortiment";
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
 <th>Количество товара</td>
 <th>Цена</td>
 <th>ID движения</td>
 <th>Код комплектующей</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['IDAssortiment']}</td>
 <td>{$row_data['Kolvo']}</td>
 <td>{$row_data['Cena']}</td>
 <td>{$row_data['Kniga_dvij_IDdvij']}</td>
 <td>{$row_data['Komplect_Kod_komplec']}</td>
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
        <form align='left' action='../Search/search_assort.php' method='POST'>
            <font size='4'>Поиск ассортимента по <br>ID документа о движении товара:</font>
            <input type="text" name="sa" size='30'>
            <input type='submit' value='Найти'/>
        </form>
        <br>
        <button onclick="window.location.href='/../InsertHTML/add_assort.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_assort.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_assort.html'">Удалить</button>
    </body>
    </html>
    </div>
<?php } else {
    header("Location: /../index.php");
}
?>
