<?php
session_start();
if (isset($_SESSION['logged_user'])) {
    ?>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Контрагенты</title>
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
    <div class="TT">
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
        $query_str = "SELECT IDkontragenta,Naimenovan,Telephone,Adress
 FROM kontragent";
        $result = $con->query($query_str);
        if ($result === FALSE) {
            $errno = $conn->errno;
            $errmsg = $conn->error;
            echo "Query Failed with: ($errno) $errmsg<br/>\n";
            $con->close();
            exit;
        } else {
            ?>
            <div class="scroll"><?php
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
            ?>
            </div>
            <?php
            $result->close();
        }
        $con->close();
        ?>
        <br><br>
        <form align='left' action='/../search_agent.php' method='POST'>
            <font size='4'>Поиск контрагента по имени:</font>
            <input type="text" name="sk" size='40'>
            <input type='submit' value='Найти'/>
        </form>
        <button onclick="window.location.href='/../InsertHTML/add_agent.html'">Добавить</button>
        &nbsp
        <button onclick="window.location.href='../UpdateHTML/update_agent.html'">Изменить</button>
        &nbsp
        <button onclick="window.location.href='../DeleteHTML/delete_agent.html'">Удалить</button>
    </div>
    </body>
    </html>
<?php } else {
    header("Location: /../index.php");
}
?>
