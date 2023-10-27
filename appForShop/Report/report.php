<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Отчет по заказам</title>
    <link rel="stylesheet" href="../styleForReport.css">
</head>
<body>
<div id="root" class="blockR">
    <?php
    $poplat = isset($_POST['so']) ? $_POST['so'] : '';
    $poplat1 = isset($_POST['so1']) ? $_POST['so1'] : '';
    include(__DIR__.'/../dbinfo.inc');
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
    if ($poplat != NULL && $poplat1 != NULL) {
        ?>
        <font size='5'> Отчет по заказам с <?php echo "$poplat"; ?> по <?php echo "$poplat1"; ?></font><br><br>
        <?php
        if (mysqli_connect_errno() != 0) {
            $errno = mysqli_connect_errno();
            $errmsg = mysqli_connect_error();
            echo "Connect Failed with: ($errno) $errmsg<br/>\n";
            exit;
        }
        $con->query("SET NAMES 'utf-8'");
        $query_str = "SELECT IDzakaza,Nomer,Data_zakaza,Naimenovan,Itogovaya_stoim,Symma_oplat
 FROM report WHERE DATE(Data_zakaza)>='$poplat' && DATE(Data_zakaza)<='$poplat1'";
        $result = $con->query($query_str);
        if ($result === FALSE) {
            $errno = $conn->errno;
            $errmsg = $conn->error;
            echo "Query Failed with: ($errno) $errmsg<br/>\n";
            $con->close();
            exit;
        } else
            echo "Время на момент формирования отчета: ";
        echo date("r");

        {
            echo <<<EOM
 <table>
 <tr>
 <th>Номер</td>
 <th>Дата заказа</td>
 <th>Наименование<br>контрагента</td>
 <th>Сумма к <br>оплате</td>
 <th>Оплачено</td>
 </tr>
EOM;
            while (($row_data = $result->fetch_assoc()) !== NULL) {
                echo <<<EOM
 <tr>
 <td>{$row_data['Nomer']}</td>
 <td>{$row_data['Data_zakaza']}</td>
 <td>{$row_data['Naimenovan']}</td>
 <td>{$row_data['Itogovaya_stoim']}</td>
 <td>{$row_data['Symma_oplat']}</td>
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
    <button class='btn' onclick='print();'>Печать или сохранение документа</button>
    <br><br>
</div>
</body>
</html>
