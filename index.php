<?php
require_once "functions.php";
$is_auth = rand(0, 1);
$user_name = 'Fool';

$data_main = ['categories'=>$categories, 'announcements'=>$announcements];
$main = include_path("index.php", $data_main);
$data_layout = array_merge(['is_auth'=>$is_auth,'user_name'=>$user_name,'main'=>$main],$data_main);
print include_path("layout.php",$data_layout);

