<?php
$categories = array(
    ['Name'=>"Доски и лыжи",'class'=>'promo__item--boards'],
    ['Name'=>"Крепления",'class'=>'promo__item--attachment'],
    ['Name'=>"Ботинки",'class'=>'promo__item--boots'],
    ['Name'=>"Одежда",'class'=>'promo__item--clothing'],
    ['Name'=>"Инструменты",'class'=>'promo__item--tools'],
    ['Name'=>"Разное",'class'=>'promo__item--other']);
$announcements = [
    ['Name'=>'2014 Rossignol District Snowboard','Category'=>'Доски и лыжи','Cost1'=>10999,'Url'=>'img/lot-1.jpg'],
    ['Name'=>'DC Ply Mens 2016/2017 Snowboard','Category'=>'Доски и лыжи','Cost1'=>159999,'Url'=>'img/lot-2.jpg'],
    ['Name'=>'Крепления Union Contact Pro 2015 года размер L/XL','Category'=>'Крепления','Cost1'=>8000,'Url'=>'img/lot-3.jpg'],
    ['Name'=>'Ботинки для сноуборда DC Mutiny Charocal','Category'=>'Ботинки','Cost1'=>10999,'Url'=>'img/lot-4.jpg'],
    ['Name'=>'Куртка для сноуборда DC Mutiny Charocal','Category'=>'Одежда','Cost1'=>7500,'Url'=>'img/lot-5.jpg'],
    ['Name'=>'Маска Oakley Canopy','Category'=>'Разное','Cost1'=>5400,'Url'=>'img/lot-6.jpg'],
];
function include_path($name, $data): string
{
    $name = 'templates/'.$name;
    $result = '!!!';
    if(!file_exists($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require($name);
    $result = ob_get_clean();
    return $result;
}
function sum_format(int $cost): string
{
    $cost=ceil($cost);
    if($cost>=1000){
        $cost = number_format($cost,0,"."," ");
    }
    return '<span class="lot__cost">'.$cost.'<b class="rub">₽</b></span>';
}
