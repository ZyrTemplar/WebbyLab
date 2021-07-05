<<<<<<< Updated upstream
<?php
$servername = "localhost"; //Название сервера
$database = "webbylab"; //Название БД
$username = "root"; //Имя пользователя БД
$password = ""; //Пароль от БД

$connect = mysqli_connect($servername, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
=======
<?php
$servername = "localhost"; //Название сервера
$database = "webbylab"; //Название БД
$username = "root"; //Имя пользователя БД
$password = ""; //Пароль от БД

$connect = mysqli_connect($servername, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
>>>>>>> Stashed changes
}