<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск ассортимента</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$pid = isset($_POST['sa']) ? $_POST['sa'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pid != NULL) {
    ?>
    <font size='5'> По поиску ассортимента на документ с кодом: <?php echo "$pid"; ?>, было найдено следующее: </font>
    <br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDAssortiment,Kolvo,Cena,Kniga_dvij_IDdvij,Komplect_Kod_komplec
 FROM assortiment WHERE Kniga_dvij_IDdvij='$pid'";
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
        // очистка набора данных
        $result->close();
    }
    //
    // освобождение соединения
    //
    $con->close();
} else { ?><font size='5'>Данные отсутствуют</font><br><?php } ?>
<br>
<button onclick="window.location.href='/../InsertHTML/add_assort.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_assort.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_assort.html'">Удалить</button>
</body>
</html>
