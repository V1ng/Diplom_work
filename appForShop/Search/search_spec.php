<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск спецификации</title>
    <link rel="stylesheet" href="../style.css">
</head>
</style>
<body>
<?php
$pid = isset($_POST['si']) ? $_POST['si'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pid != NULL) {
    ?>
    <font size='5'> Поиск спецификации по заказу с ID <?php echo "$pid"; ?>, было найдено следующее: </font><br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDspecifikacii,Kolvo_tovara,Cena,Zakaz_IDzakaza,Komplect_Kod_komplect
 FROM specifikaciya WHERE Zakaz_IDzakaza='$pid'";
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
 <th>Количество товара</td>
 <th>Цена</td>
 <th>ID заказа</td>
 <th>Код комплектующей</td>
 </tr>
EOM;
        while (($row_data = $result->fetch_assoc()) !== NULL) {
            echo <<<EOM
 <tr>
 <td>{$row_data['IDspecifikacii']}</td>
 <td>{$row_data['Kolvo_tovara']}</td>
 <td>{$row_data['Cena']}</td>
 <td>{$row_data['Zakaz_IDzakaza']}</td>
 <td>{$row_data['Komplect_Kod_komplect']}</td>
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
<button onclick="window.location.href='/../InsertHTML/add_spec.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_spec.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_spec.html'">Удалить</button>
</body>
</html>
