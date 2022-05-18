<?php
require_once "functions.php";
$is_auth = rand(0, 1);
$user_name = 'Fool';
$connection = new mysqli('127.0.0.1','root','','yeticave_tikhonov');
$query = "Select * from category order by ID_category";
$category_result = $connection->query($query);
$categories = $category_result->fetch_all(MYSQLI_ASSOC);
$query = "select ID_announcements as ID, a.Name as Name,
       Start_cost,
       a.Image,
       (COALESCE(sum(b.Sum),0)+a.Start_cost) Cost,
       count(b.Sum) Bets,
       c.Name as Category,
       ID_winner
from announcement as a
       left join bet b
                 on a.ID_announcements = b.ID_announcement
       inner join category c on a.ID_category = c.ID_category
group by a.Name, Start_cost, Image,Date_of_creating,ID_winner,ID
having ISNULL(ID_winner)
order by Date_of_creating desc;";
$announcements_result = $connection->query($query);
$announcements = $announcements_result->fetch_all(1);
$data_main = ['categories'=>$categories, 'announcements'=>$announcements];
$main = include_path("index.php", $data_main);
$data_layout = array_merge(['is_auth'=>$is_auth,'user_name'=>$user_name,'main'=>$main,'page_name'=>"Главная"],$data_main);
print include_path("layout.php",$data_layout);

