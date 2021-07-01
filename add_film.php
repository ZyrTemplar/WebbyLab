<?php
session_start();
require ("bd_conf/bd_connect.php");

$redirect=$_SERVER['HTTP_REFERER'];
$title=$_POST['title'];
$year=$_POST['year'];
$format=$_POST['format'];
$actors=$_POST['actors'];

echo $title;
echo '<br>';
echo '<br>';
echo $year;
echo '<br>';
echo '<br>';
echo $format;
echo '<br>';
echo '<br>';
echo $actors;

$actors=explode(', ',$actors);

echo '<br>';
echo '<br>';
print_r($actors);

echo '<br>';
echo '<br>';

if ($format!='VHS'&&$format!='DVD'&&$format!='Blu-Ray'){
    $_SESSION['messages']['format']='Что за формат вы указали?';
    header("Location: $redirect");
}

if (iconv_strlen($title)>60){
    $_SESSION['messages']['title']='Слишком длинное название';
    header("Location: $redirect");
}

if (iconv_strlen($title)<=0){
    $_SESSION['messages']['title']='Название отсутствует';
    header("Location: $redirect");
}

if ($year<1895){
    $_SESSION['messages']['year']='Первый фильм был в 1895 году';
    header("Location: $redirect");
}

if ($year>2021){
    $_SESSION['messages']['year']='Только вышедшие фильмы';
    header("Location: $redirect");
}

if (empty($actors)){
    $_SESSION['messages']['actors']='Что-то не так с актерами';
    header("Location: $redirect");
}

$connect->query("INSERT INTO films(title, year, format) VALUES ('$title', '$year', '$format')");
$film=$connect->insert_id;

foreach ($actors as $actor){
    $connect->query("INSERT INTO actors(actor) VALUES ('$actor')");
    $actor=$connect->insert_id;
    $insert="INSERT INTO `films_to_actors`(`film_id`, `actor_id`) VALUES ('$film','$actor')";
}

$_SESSION['success']='Фильм был успешно добавлен';

header("Location: $redirect");