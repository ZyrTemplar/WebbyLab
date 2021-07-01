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
exit( );