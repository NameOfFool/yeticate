<?php
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
