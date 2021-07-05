<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <title>WebbyLab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
require ("bd_conf/bd_connect.php");
$temp=$connect->query('SELECT films.id,films.title, films.year, films.format FROM films ORDER BY title');
$actors=$connect->query('SELECT films.title, actors.actor FROM actors, films, films_to_actors WHERE films.id=films_to_actors.film_id AND actors.id=films_to_actors.actor_id');
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
    foreach ($actors as $actor){
        if ($film['title']==$actor['title']) {
            array_push($films[$count]['actors'], $actor['actor']);
        }
    }
    $count++;
}
echo "<table border='1' cellpadding='4'>";
echo " <thead>
   <tr>
    <th>Id фильма</th>
    <th>Название</th>
    <th>Год выпуска</th>
    <th>Формат</th>
    <th>Актеры</th>
   </tr>
   </thead>";
foreach ($films as $film){
    foreach ($film as $key=>$val){
        if ($key=='actors'){
            echo "<td>";
            foreach ($val as $number=> $value){
                if ($number==0) echo $value;
                else echo ', '.$value;
            }
        }
        else{
        echo "<td>";
        echo $val;
        }
        echo "</td>";
    }
    echo "<td class='delete'>";
    echo "<a href='delete_film.php?film_id=".$film['id']."'>Удалить фильм</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <title>WebbyLab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
require ("bd_conf/bd_connect.php");
$col_films=10;
$page=$_GET['page'];
$all=$connect->query('SELECT COUNT(*) FROM films');
foreach ($all as $value){
    $films_count=$value['COUNT(*)'];
}
$total =intval(($films_count - 1) / $col_films) + 1;
$page=intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $col_films - $col_films;
$temp=$connect->query("SELECT films.id,films.title, films.year, films.format FROM films ORDER BY title COLLATE  utf8_unicode_ci LIMIT ".$start.", ".$col_films);
$actors=$connect->query('SELECT films.id, actors.actor FROM actors, films, films_to_actors WHERE films.id=films_to_actors.film_id AND actors.id=films_to_actors.actor_id');
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
    foreach ($actors as $actor){
        if ($film['id']==$actor['id']) {
            array_push($films[$count]['actors'], $actor['actor']);
        }
    }
    $count++;
}
echo "<table border='1' cellpadding='4'>";
echo " <thead>
   <tr>
    <th>Id фильма</th>
    <th>Название</th>
    <th>Год выпуска</th>
    <th>Формат</th>
    <th>Актеры</th>
   </tr>
   </thead>";
foreach ($films as $film){
    foreach ($film as $key=>$val){
        if ($key=='actors'){
            echo "<td>";
            foreach ($val as $number=> $value){
                if ($number==0) echo $value;
                else echo ', '.$value;
            }
        }
        else{
        echo "<td>";
        echo $val;
        }
        echo "</td>";
    }
    echo "<td>";
    echo "<button class='delete' id='".$film['id']."'>Удалить фильм</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
if ($films_count>10){
    if ($page != 1) $pervpage = '<a href= /select_films.php?page=1><<</a>
                                   <a href= /select_films.php?page=' . ($page - 1) . '><</a> ';
    if ($page != $total) $nextpage = ' <a href= /select_films.php?page=' . ($page + 1) . '>></a>
                                       <a href= /select_films.php?page=' . $total . '>>></a>';
    if ($page - 2 > 0) $page2left = ' <a href= /select_films.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
    if ($page - 1 > 0) $page1left = '<a href= /select_films.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';
    if ($page + 2 <= $total) $page2right = ' | <a href= /select_films.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
    if ($page + 1 <= $total) $page1right = ' | <a href= /select_films.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';
    echo $pervpage . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $nextpage;
}
?>
<br>
<br>
<a href="index.php" style="font-size: 24px; margin-top: 10px">На главную</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.delete').click(function (e) {
        temp=confirm('Точно удалить?');
        if (temp===true){
            href='delete_film.php?film_id="'+e.target.id+'"'
            window.location.href = href;
        }
    })
</script>
</body>
</html>
>>>>>>> Stashed changes
