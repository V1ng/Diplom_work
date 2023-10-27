<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск документа о движении</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$pnomer = isset($_POST['sn']) ? $_POST['sn'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pnomer != NULL) {
    ?>
    <font size='5'> По поиску документа с номером <?php echo "$pnomer"; ?>, было найдено следующее: </font><br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDdvij,Nomer_doc,Kod_oper,Data,Obchaya_stoim,Kontragent_IDkontragenta,Zakaz_IDzakaza
 FROM kniga_dvij WHERE Nomer_doc='$pnomer'";
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
        // очистка набора данных
        $result->close();
    }
    //
    // освобождение соединения
    //
    $con->close();
} else { ?><font size='5'>Данные отсутствуют</font><br><?php } ?>
<br>
<button onclick="window.location.href='/../InsertHTML/add_dvij.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_dvij.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_dvij.html'">Удалить</button>
</body>
</html>
