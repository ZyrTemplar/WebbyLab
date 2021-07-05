<<<<<<< Updated upstream
<?php
session_start();
require ("bd_conf/bd_connect.php");
    $arr=array();
    $count=1;
    $number=0;
    $element=array();
    $temp=array();
    $file=fopen($_FILES['path']['tmp_name'],'r');
    while (!feof($file)){
        array_push($temp,fgets($file)) ;
    }
    foreach ($temp as $key=>$value){
        if ($value==PHP_EOL){
            unset($temp[$key]);
        }
    }
    foreach ($temp as $value){
        $elem=explode(':',$value);
        if (count($elem)<2){
            continue;                //В начале и в конце файла есть невидимые симловолы, которые записываються как один элемент, так что я их пропускаю
        }
        $elem[0]=trim($elem[0]);
        $elem[1]=trim($elem[1]);
        $element[$elem[0]]=$elem[1];
        if ($count>=4){
            $element['Stars']=explode(', ',$element['Stars']);
            $count=0;
            $arr[$number]=$element;
            $number++;
            $element=[];
        }
        $count++;
    }
    foreach ($arr as $value){
        $title=$value['Title'];
        $year=$value['Release Year'];
        $format=$value['Format'];
        $connect->query("INSERT INTO films(title, year, format) VALUES ('$title', '$year', '$format')");
        $film=$connect->insert_id;
        foreach ($value as $key=>$val){
            if ($key=='Stars'){
                foreach ($val as $star){
                    $connect->query("INSERT INTO actors(actor) VALUES ('$star')");
                    $actor=$connect->insert_id;
                    $connect->query("INSERT INTO `films_to_actors`(`film_id`, `actor_id`) VALUES ('$film','$actor')");
                }
            }
        }
    }
    fclose($file);
    $redirect=$_SERVER['HTTP_REFERER'];
$_SESSION['success_file']='Фильмы были успешно добавлены';
header("Location: $redirect");
=======
<?php
session_start();
require ("bd_conf/bd_connect.php");
$temp=$connect->query('SELECT films.id,films.title, films.year, films.format FROM films ORDER BY title COLLATE  utf8_unicode_ci');
$actors_temp=$connect->query('SELECT films.title, actors.actor FROM actors, films, films_to_actors WHERE films.id=films_to_actors.film_id AND actors.id=films_to_actors.actor_id');
$films=array();
$count=0;
$repeats=0;
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
    $arr=array();
    $count=1;
    $number=0;
    $element=array();
    $temp=array();
    $redirect=$_SERVER['HTTP_REFERER'];
    if (empty($_FILES['path']['type'])){
        $_SESSION['error_file']='У вас ошибка в файле';
        header("Location: $redirect");
        exit( );
    }
    elseif($_FILES['path']['type']!='text/plain'){
        $_SESSION['error_file']='Это не *.txt файл';
        header("Location: $redirect");
        exit( );
    }
    elseif(filesize($_FILES['path']['tmp_name'])==3){
        $_SESSION['error_file']='Файл пустой';
        header("Location: $redirect");
        exit( );
    }
    else{
        $file=fopen($_FILES['path']['tmp_name'],'r');
    }
    while (!feof($file)){
        array_push($temp,fgets($file)) ;
    }
    foreach ($temp as $key=>$value){
        if ($value==PHP_EOL){
            unset($temp[$key]);
        }
    }

    foreach ($temp as $value){
        $elem=explode(':',$value);
        if (count($elem)<2){
            continue;                //В начале и в конце файла есть невидимые симловолы, которые записываються как один элемент, так что я их пропускаю
        }
        $elem[0]=trim($elem[0]);
        $elem[1]=trim($elem[1]);
        $element[$elem[0]]=$elem[1];
        if ($count>=4){
            $element['Stars']=explode(', ',$element['Stars']);
            $count=0;
            $arr[$number]=$element;
            $number++;
            $element=[];
        }
        $count++;
    }
    foreach ($arr as $value){
        $title=$value['Title'];
        $year=$value['Release Year'];
        $format=$value['Format'];
        foreach ($films as $film){
            if ($film['title']==$title){
                if ($film['year']==$year&&$film['format']==$format){
                    foreach ($value as $key=>$val){
                        if ($key=='Stars'){
                            if (count($film['actors'])==count($val)){
                                foreach ($film['actors'] as $actor1){
                                    foreach ($val as $star){
                                        if ($actor1==$star){
                                            $repeats++;
                                            continue 5;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $connect->query("INSERT INTO films(title, year, format) VALUES ('$title', '$year', '$format')");
        $film=$connect->insert_id;
        foreach ($value as $key=>$val){
            if ($key=='Stars'){
                foreach ($val as $star){
                    $connect->query("INSERT INTO actors(actor) VALUES ('$star')");
                    $actor=$connect->insert_id;
                    $connect->query("INSERT INTO `films_to_actors`(`film_id`, `actor_id`) VALUES ('$film','$actor')");
                }
            }
        }
    }
    fclose($file);
if ($repeats!=0) $_SESSION['repeats']="Было проигнорировано $repeats записей";
$_SESSION['success_file']='Фильмы были успешно добавлены';
header("Location: $redirect");
>>>>>>> Stashed changes
exit( );