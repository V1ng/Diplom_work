<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск по товарам</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$pnaimenovan = isset($_POST['sk']) ? $_POST['sk'] : '';
$pproiz = isset($_POST['sp']) ? $_POST['sp'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pnaimenovan != NULL || $pproiz != NULL) {
    if ($pnaimenovan != NULL) {
        ?>
        <font size='5'> По поиску комплектующих с наименованием <?php echo "$pnaimenovan"; ?> было найдено
            следующее: </font><br><br>
    <?php } elseif ($pproiz != NULL) {
        ?>
        <font size='5'> По поиску комплектующих от производителя <?php echo "$pproiz"; ?> было найдено
            следующее: </font><br><br>
    <?php }
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    if ($pnaimenovan != NULL) {
        $query_str1 = "SELECT Kod_komplect,Naimen_komplect,Model,Proizvoditel,Vid_komplect_Kod_vida
 FROM komplect WHERE Naimen_komplect='$pnaimenovan'";
        $result = $con->query($query_str1);
    } else {
        $query_str2 = "SELECT Kod_komplect,Naimen_komplect,Model,Proizvoditel,Vid_komplect_Kod_vida
   FROM komplect WHERE Proizvoditel='$pproiz'";
        $result = $con->query($query_str2);
    }
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
 <th>Наименование</td>
 <th>Модель</td>
 <th>Производитель</td>
 <th>Вид комплектующей</td>
 </tr>
EOM;
        while (($row_data = $result->fetch_assoc()) !== NULL) {
            echo <<<EOM
 <tr>
 <td>{$row_data['Kod_komplect']}</td>
 <td>{$row_data['Naimen_komplect']}</td>
 <td>{$row_data['Model']}</td>
 <td>{$row_data['Proizvoditel']}</td>
 <td>{$row_data['Vid_komplect_Kod_vida']}</td>
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
<button onclick="window.location.href='/../InsertHTML/add_komplect.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_komplect.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_komplect.html'">Удалить</button>
</body>
</html>
