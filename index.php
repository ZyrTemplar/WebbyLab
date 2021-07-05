<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require ("bd_conf/bd_connect.php");
?>
<head>
    <meta charset='UTF-8'>
    <title>WebbyLab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Добавление файла в бд</h1>
<div class="add">
<?php
    if (!empty($_SESSION['success_file'])){
        echo '<div class="success">';
            echo $_SESSION['success_file'];
            echo '<br>';
        echo '</div>';
            echo '<br>';
    }
    unset($_SESSION['success_file']);
?>
    <form action="file_open.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" required name="path" id="path" accept=".txt"><br>
        <button type="submit" style="margin-top: 20px">Отправить</button>
    </form>
</div>

<h1>Добавление фильма</h1>
<div class="add_film">
    <?php
    if (!empty($_SESSION['messages'])){
        echo '<div class="alert">';
        foreach ($_SESSION['messages'] as $value){
            echo $value;
            echo '<br>';
        }
        echo '</div>';
    }
    unset($_SESSION['messages']);

    if (!empty($_SESSION['success'])){
        echo '<div class="success">';
            echo $_SESSION['success'];
            echo '<br>';
        echo '</div>';
        echo '<br>';
    }
    unset($_SESSION['success']);
    ?>
    <form action="add_film.php" method="post">
        <label for="title">Название фильма</label><br>
        <input type="text" id="title" maxlength="60" name="title" style="width: 300px"  required placeholder="Форсаж 28"><br><br>

        <label for="year">Год выпуска</label><br>
        <input id="year" type="number" min="1895" max="2021" name="year" style="width: 50px"  required placeholder="1895"><br><br>

        <label for="format">Формат</label><br>
        <select name="format" required id="format">
            <option value="VHS">VHS</option>
            <option value="DVD">DVD</option>
            <option value="Blu-Ray">Blu-Ray</option>
        </select><br><br>

        <label for="actors">Актеры (через запятую, после запятой пробел)</label><br>
        <textarea id="actors" name="actors"  style="width: 500px"  required placeholder="Бенадрил Камберпатч, Бенефис Камбербера"></textarea><br><br>

        <button type="submit">Отправить</button>
        <button type="reset">Очистить</button>
    </form>
</div>
<a href="select_films.php"><h1>Cписок всех фильмов + сортировка + удаление(это ссылка)</h1></a>

<h1>Поиск по названию</h1>
<div class="add">
<form action="search_title.php" method="post">
    <input type="text" required id="title_search" name="title_search" placeholder="Jaws">
    <button type="submit">Поиск</button>
</form>
</div>

<h1>Поиск по актерам</h1>
<div class="add">
<form action="search_actors.php" method="post">
    <input type="text" required id="actor_search" name="actor_search" placeholder="Carl Reiner">
    <button type="submit">Поиск</button>
</form>
</div>
</body>
=======
<?php
session_start();
require ("bd_conf/bd_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <title>WebbyLab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Добавление файла в бд</h1>
<div class="add">
<?php
    if (!empty($_SESSION['success_file'])){
        echo '<div class="success">';
            echo $_SESSION['success_file'];
            echo '<br>';
        echo '</div>';
            echo '<br>';
    }
    unset($_SESSION['success_file']);
    if (!empty($_SESSION['error_file'])){
        echo '<div class="alert">';
            echo $_SESSION['error_file'];
            echo '<br>';
        echo '</div>';
            echo '<br>';
    }
    unset($_SESSION['error_file']);
    if (!empty($_SESSION['repeats'])){
        echo '<div class="alert">';
            echo $_SESSION['repeats'];
            echo '<br>';
        echo '</div>';
            echo '<br>';
    }
    unset($_SESSION['repeats']);
?>
    <form action="file_open.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" required name="path" id="path" accept=".txt"><br>
        <button type="submit" style="margin-top: 20px">Отправить</button>
    </form>
</div>

<h1>Добавление фильма</h1>
<div class="add_film">
    <?php
    if (!empty($_SESSION['messages'])){
        echo '<div class="alert">';
        foreach ($_SESSION['messages'] as $value){
            echo $value;
            echo '<br>';
        }
        echo '</div>';
    }
    unset($_SESSION['messages']);

    if (!empty($_SESSION['success'])){
        echo '<div class="success">';
            echo $_SESSION['success'];
            echo '<br>';
        echo '</div>';
        echo '<br>';
    }
    unset($_SESSION['success']);
    ?>
    <form action="add_film.php" method="post">
        <label for="title">Название фильма</label><br>
        <input type="text" id="title" maxlength="60" name="title" style="width: 300px" value="<?php if (!empty($_SESSION['data'])) echo $_SESSION['data']['title']; unset($_SESSION['data']['title']); ?>" required placeholder="Форсаж 28"><br><br>

        <label for="year">Год выпуска</label><br>
        <input id="year" type="number" min="1895" max="2021" name="year" style="width: 50px"  value="<?php if (!empty($_SESSION['data'])) echo $_SESSION['data']['year']; unset($_SESSION['data']['year']); ?>"  required placeholder="1895"><br><br>

        <label for="format">Формат</label><br>
        <select name="format" required id="format">
            <option value="VHS" <?php if($_SESSION['data']['format']=="VHS")echo 'selected'?> >VHS</option>
            <option value="DVD" <?php if($_SESSION['data']['format']=="DVD")echo 'selected'?>>DVD</option>
            <option value="Blu-Ray" <?php if($_SESSION['data']['format']=="Blu-Ray")echo 'selected'?>>Blu-Ray</option>
        </select><br><br>
        <?php unset($_SESSION['data']['format']); ?>
        <label for="actors">Актеры (через запятую, после запятой пробел)</label><br>
        <textarea id="actors" name="actors"  style="width: 500px" required placeholder="Бенадрил Камберпатч, Бенефис Камбербера"><?php if (!empty($_SESSION['data'])) echo $_SESSION['data']['actors']; unset($_SESSION['data']['actors']); ?></textarea><br><br>

        <button type="submit">Отправить</button>
        <button type="reset">Очистить</button>
    </form>
</div>
<a href="select_films.php"><h1>Cписок всех фильмов + сортировка + удаление(это ссылка)</h1></a>

<h1>Поиск по названию</h1>
<div class="add">
<form action="search_title.php" method="post">
    <input type="text" required id="title_search" name="title_search" placeholder="Jaws">
    <button type="submit">Поиск</button>
</form>
</div>

<h1>Поиск по актерам</h1>
<div class="add">
<form action="search_actors.php" method="post">
    <input type="text" required id="actor_search" name="actor_search" placeholder="Carl Reiner">
    <button type="submit">Поиск</button>
</form>
</div>
</body>
>>>>>>> Stashed changes
</html>