<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="aut">
    <form action='aut.php' method='POST'>
        <table align='center'>
            <th colspan="2">Авторизация</th>
            <tr>
                <td>Логин</td>
                <td><input name='login'><br><br></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td><input name='password' type='password'><br><br>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type='submit' name="Submit" value='Отправить'></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
