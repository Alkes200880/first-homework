<div id="container">
    <h1>Добро пожаловать!</h1>

    <div id="body">
        <pre>
        <form method="post" action="/welcome/addUser">
            Логин  :<input name="Login" type="text">
            Пароль :<input name="Pass" type="text">
            Почта  :<input name="mail" type="text">

            <button type="submit">Регистрация</button>
        </form>
        </pre>

        <div id="return"></div>
<?php
//echo "<pre>";
//print_r("привет");
//echo "</pre>";

?>
    </div>
</div>