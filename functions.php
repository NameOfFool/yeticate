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
function connection(): mysqli
{
    return new mysqli('127.0.0.1','root','','yeticave_tikhonov');
}
function categories(mysqli $connection): array
{
    $query = "Select * from category order by ID_category";
    $category_result = $connection->query($query);
    return $category_result->fetch_all(MYSQLI_ASSOC);
}

