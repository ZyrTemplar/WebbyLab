<<<<<<< Updated upstream
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

=======
<?php
session_start();
require ("bd_conf/bd_connect.php");
$redirect=$_SERVER['HTTP_REFERER'];
$title=$_POST['title'];
$year=$_POST['year'];
$format=$_POST['format'];
$actors=$_POST['actors'];

$temp=$connect->query('SELECT films.id,films.title, films.year, films.format FROM films ORDER BY title COLLATE  utf8_unicode_ci');
$actors_temp=$connect->query('SELECT films.title, actors.actor FROM actors, films, films_to_actors WHERE films.id=films_to_actors.film_id AND actors.id=films_to_actors.actor_id');
$films=array();
$count=0;
foreach ($temp as $film){
    $films[$count]['id']=$film['id'];
    $films[$count]['title']=$film['title'];
    $films[$count]['year']=$film['year'];
    $films[$count]['format']=$film['format'];
    $films[$count]['actors']=array();
    $count++;
}
$count=0;
foreach ($temp as $film){
    foreach ($actors_temp as $actor){
        if ($film['title']==$actor['title']) {
            array_push($films[$count]['actors'], $actor['actor']);
        }
    }
    $count++;
}

$validate=preg_match("/^[а-я А-Я a-z A-Z,-]+$/u",$actors);

if(!$validate){
    $_SESSION['messages']['title']='В строку актеры введены не разрешенные символы';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if (ctype_space($actors)){
    $_SESSION['messages']['title']='Вы не указали актеров';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

$actors=explode(', ',$actors);


if ($format!='VHS'&&$format!='DVD'&&$format!='Blu-Ray'){
    $_SESSION['messages']['format']='Что за формат вы указали?';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if (ctype_space($title)){
    $_SESSION['messages']['title']='Вы не указали название';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if (iconv_strlen($title)>60){
    $_SESSION['messages']['title']='Слишком длинное название';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if (iconv_strlen($title)<=0){
    $_SESSION['messages']['title']='Название отсутствует';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if ($year<1895){
    $_SESSION['messages']['year']='Первый фильм был в 1895 году';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if ($year>2021){
    $_SESSION['messages']['year']='Только вышедшие фильмы';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}

if (empty($actors)){
    $_SESSION['messages']['actors']='Что-то не так с актерами';
    $_SESSION['data']['title']=$title;
    $_SESSION['data']['year']=$year;
    $_SESSION['data']['format']=$format;
    $_SESSION['data']['actors']=$_POST['actors'];
    header("Location: $redirect");
    exit( );
}


for ($i=0;$i<count($actors) ; $i++)
{
    for ($j=$i+1; $j<count($actors); $j++)
    {
        $actor1=$actors[$i];
        $actor2=$actors[$j];
        if ($actor1==$actor2){
            $_SESSION['messages']['actors']='Вы ввели 2 одинаковых актера';
            header("Location: $redirect");
            exit( );
        }
    }
}

foreach ($films as $film){
    if ($film['title']==$title){
        if ($film['year']==$year&&$film['format']==$format){
            if (count($film['actors'])==count($actors)){
                foreach ($film['actors'] as $actor1){
                    foreach ($actors as $actor2){
                        if ($actor1==$actor2){
                            $_SESSION['messages']['actors']='Вы ввели фильм который уже существует';
                            header("Location: $redirect");
                            exit( );
                        }
                    }
                }
            }
        }
    }
}

$connect->query("INSERT INTO films(title, year, format) VALUES ('$title', '$year', '$format')");
$film_id=$connect->insert_id;

foreach ($actors as $actor){
    $connect->query("INSERT INTO actors(actor) VALUES ('$actor')");
    $actor_id=$connect->insert_id;
    $insert="INSERT INTO `films_to_actors`(`film_id`, `actor_id`) VALUES ('$film_id','$actor_id')";
    $connect->query($insert);
}

$_SESSION['success']='Фильм был успешно добавлен';
>>>>>>> Stashed changes
header("Location: $redirect");