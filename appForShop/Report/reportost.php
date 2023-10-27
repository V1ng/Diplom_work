<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Отчет по заказам</title>
    <link rel="stylesheet" href="../styleForReport.css">
</head>
<body>
<div id="root" class="blockR">
    <?php
    include(__DIR__.'/../dbinfo.inc');
    $con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname); ?>
    <font size='5'> Отчет по остаткам на складе</font><br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDostatka,Kolvo,Cena,Naimen_komplect,Model,Full_stoim
 FROM reportost";
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
 <th>Наименование <br>комплектующей</td>
 <th>Модель</td>
 <th>Количество</td>
 <th>Цена</td>
 <th>Стоимость <br>складского <br>запаса</th>
 </tr>
EOM;
        while (($row_data = $result->fetch_assoc()) !== NULL) {
            echo <<<EOM
 <tr>
 <td>{$row_data['Naimen_komplect']}</td>
 <td>{$row_data['Model']}</td>
 <td>{$row_data['Kolvo']}</td>
 <td>{$row_data['Cena']}</td>
 <td>{$row_data['Full_stoim']}</td>
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
    ?>
    <button class='btn' onclick='print();'>Печать или сохранение документа</button>
    <br><br>
</div>
</body>
</html>
