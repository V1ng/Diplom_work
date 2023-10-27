<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Поиск контрагентов</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$pnaimenovan = isset($_POST['sk']) ? $_POST['sk'] : '';
include(__DIR__.'/../dbinfo.inc');
$con = @new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if ($pnaimenovan != NULL) {
    ?>
    <font size='5'> По поиску контрагента с наименованием <?php echo "$pnaimenovan"; ?>, было найдено следующее: </font>
    <br><br>
    <?php
    if (mysqli_connect_errno() != 0) {
        $errno = mysqli_connect_errno();
        $errmsg = mysqli_connect_error();
        echo "Connect Failed with: ($errno) $errmsg<br/>\n";
        exit;
    }
    $con->query("SET NAMES 'utf-8'");
    $query_str = "SELECT IDkontragenta,Naimenovan,Telephone,Adress
 FROM kontragent WHERE Naimenovan='$pnaimenovan'";
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
 <th>Наименование</td>
 <th>Телефон</td>
 <th>Адрес</td>
 </tr>
EOM;
        while (($row_data = $result->fetch_assoc()) !== NULL) {
            echo <<<EOM
 <tr>
 <td>{$row_data['IDkontragenta']}</td>
 <td>{$row_data['Naimenovan']}</td>
 <td>{$row_data['Telephone']}</td>
 <td>{$row_data['Adress']}</td>
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
<button onclick="window.location.href='/../InsertHTML/add_agent.html'">Добавить</button>
&nbsp
<button onclick="window.location.href='/../UpdateHTML/update_agent.html'">Изменить</button>
&nbsp
<button onclick="window.location.href='/../DeleteHTML/delete_agent.html'">Удалить</button>
</body>
</html>
