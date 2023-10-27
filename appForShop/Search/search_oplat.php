<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск оплат</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$poplat = isset($_POST['so']) ? $_POST['so'] : '';
$poplat1 = isset($_POST['so1']) ? $_POST['so1'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($poplat != NULL && $poplat1 != NULL) {
    ?>
    <font size='5'> По поиску оплат с <?php echo "$poplat"; ?> по <?php echo "$poplat1"; ?> было найдено
        следующее: </font><br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDoplat,Symma_oplat,Sposob_oplat,Data_oplat,Zakaz_IDzakaza
 FROM kniga_oplat WHERE DATE(Data_oplat)>='$poplat' && DATE(Data_oplat)<='$poplat1'";
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
        // очистка набора данных
        $result->close();
    }
    //
    // освобождение соединения
    //
    $con->close();
} else { ?><font size='5'>Данные отсутствуют</font><br><?php } ?>
<br>
<button onclick="window.location.href='/../InsertHTML/add_oplat.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_oplat.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_oplat.html'">Удалить</button>
</body>
</html>
