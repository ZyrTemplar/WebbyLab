<<<<<<< Updated upstream
<?php
require ("bd_conf/bd_connect.php");
$redirect=$_SERVER['HTTP_REFERER'];
$film=$_GET['film_id'];
$actors=array();
$temp=$connect->query("SELECT * FROM films_to_actors WHERE film_id=$film");
foreach ($temp as $val){
    array_push($actors,$val['actor_id']);
}
$connect->query("DELETE FROM films_to_actors WHERE film_id=$film");
$connect->query("DELETE FROM films WHERE id=$film");
foreach ($actors as $actor){
    $connect->query("DELETE FROM actors WHERE id=$actor");
}
=======
<?php
require ("bd_conf/bd_connect.php");
$redirect=$_SERVER['HTTP_REFERER'];
$film=$_GET['film_id'];
$actors=array();
$temp=$connect->query("SELECT * FROM films_to_actors WHERE film_id=$film");
foreach ($temp as $val){
    array_push($actors,$val['actor_id']);
}
$connect->query("DELETE FROM films_to_actors WHERE film_id=$film");
$connect->query("DELETE FROM films WHERE id=$film");
foreach ($actors as $actor){
    $connect->query("DELETE FROM actors WHERE id=$actor");
}
>>>>>>> Stashed changes
header("Location: $redirect");