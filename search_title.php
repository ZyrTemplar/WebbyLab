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
$found=false;
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
    if ($film['title']==$_POST['title_search']){
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
        $found=true;
    }
}
if ($found==false){
    echo '<tr><td>Фильм не найден</td></tr>';
}
echo "</table>";
?>
<a href="index.php" style="font-size: 24px; margin-top: 10px">На главную</a>
</body>
</html>
