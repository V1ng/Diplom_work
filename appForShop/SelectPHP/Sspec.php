<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Спецификация</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    </style>
    <body>
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
    $query_str = "SELECT IDspecifikacii,Kolvo_tovara,Cena,Zakaz_IDzakaza,Komplect_Kod_komplect
 FROM specifikaciya";
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
    ?>
    <br>
    <form align='left' action='../Search/search_spec.php' method='POST'>
        <font size='4'>Поиск спецификаций по ID заказа:</font>
        <input type="text" name="si" size='10'>
        <input type='submit' value='Найти'/>
    </form>
    <button onclick="window.location.href='/../InsertHTML/.html'">Добавить</button>
    &nbsp
    <button onclick="window.location.href='../UpdateHTML/update_spec.html'">Изменить</button>
    &nbsp
    <button onclick="window.location.href='../DeleteHTML/delete_spec.html'">Удалить</button>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
