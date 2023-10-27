<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск заказов</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$pnomer = isset($_POST['sz']) ? $_POST['sz'] : '';
$poplat = isset($_POST['so']) ? $_POST['so'] : '';
$poplat1 = isset($_POST['so1']) ? $_POST['so1'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pnomer != NULL || $poplat != NULL || $poplat1 != NULL) {
    if ($pnomer != NULL && $poplat == NULL && $poplat1 == NULL) {
        ?>
        <font size='5'> По поиску заказа с номером <?php echo "$pnomer"; ?>, было найдено следующее: </font><br><br>
    <?php } elseif ($pnomer == NULL && $poplat != NULL && $poplat1 != NULL) {
        ?>
        <font size='5'> По поиску заказа с <?php echo "$poplat"; ?> по <?php echo "$poplat1"; ?>, было найдено
            следующее: </font><br><br>
    <?php } elseif ($pnomer != NULL && $poplat != NULL && $poplat1 != NULL) {
        ?>
        <font size='5'> По поиску заказа с номером <?php echo "$pnomer"; ?> и с <?php echo "$poplat"; ?>
            по <?php echo "$poplat1"; ?>, было найдено следующее: </font><br><br>
    <?php }
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    if ($pnomer != NULL && $poplat == NULL && $poplat1 == NULL) {
        $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Itogovaya_stoim,Kontragent_IDkontragenta
 FROM zakaz WHERE Nomer='$pnomer'";
    } elseif ($pnomer == NULL && $poplat != NULL && $poplat1 != NULL) {
        $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Itogovaya_stoim,Kontragent_IDkontragenta
 FROM zakaz WHERE DATE(Data_zakaza)>='$poplat' && DATE(Data_zakaza)<='$poplat1'";
    } else ($pnomer != NULL && $poplat != NULL && $poplat1 != NULL){
    $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Itogovaya_stoim,Kontragent_IDkontragenta
 FROM zakaz WHERE Nomer='$pnomer' AND DATE(Data_zakaza)>='$poplat' && DATE(Data_zakaza)<='$poplat1'"
    };
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
        // очистка набора данных
        $result->close();
    }
    //
    // освобождение соединения
    //
    $con->close();
} else { ?><font size='5'>Данные отсутствуют</font><br><?php } ?>
<br>
<button onclick="window.location.href='/../InsertHTML/add_zakaz.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_zakaz.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_zakaz.html'">Удалить</button>
</body>
</html>
