<?php
require_once 'bd_connect.php';

if (!$connect->query('DROP TABLE IF EXISTS films')||
    !$connect->query('CREATE TABLE films (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT ,year INT(4), title CHAR(60), format CHAR (15))')) {
    echo "Не удалось создать таблицу: (" . $connect->errno . ") " . $connect->error.'<br>';
}
if (!$connect->query('DROP TABLE IF EXISTS actors')||
    !$connect->query('CREATE TABLE actors (id INT NOT  NULL PRIMARY KEY AUTO_INCREMENT , actor CHAR(60))')) {
    echo "Не удалось создать таблицу: (" . $connect->errno . ") " . $connect->error.'<br>';
}
if (!$connect->query('DROP TABLE IF EXISTS films_to_actors')||
    !$connect->query('CREATE TABLE films_to_actors (film_id INT NOT  NULL, actor_id INT NOT NULL,  CONSTRAINT film_id FOREIGN KEY (film_id) REFERENCES films(id),  CONSTRAINT actor_id FOREIGN KEY (actor_id) REFERENCES actors(id))')) {
    echo "Не удалось создать таблицу: (" . $connect->errno . ") " . $connect->error.'<br>';
}