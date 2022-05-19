<?php
require_once "functions.php";
$is_auth = rand(0, 1);
$user_name = 'Fool';
$ID = $_GET['l'];
$connection = connection();
$categories = categories($connection);
$query = "select ID_announcements as ID, a.Name as Name,
       Start_cost,
       Description,
       a.Image,
       (COALESCE(sum(b.Sum),0)+a.Start_cost) Cost,
       count(b.Sum) Bets,
       c.Name as Category,
       Bet_step as Min

from announcement as a
       left join bet b
                 on a.ID_announcements = b.ID_announcement
       inner join category c on a.ID_category = c.ID_category
group by a.Name, Start_cost, Image,Date_of_creating,Min,ID,Description
having ID=$ID";
$announcement_result = $connection->query($query);
if(isset($ID)&&$announcement_result)
{
    $announcement = $announcement_result->fetch_array(1);
    $announcement['Min'] = (double)$announcement['Min'] + (double)$announcement['Cost'];
    $query = "Select User_name,Sum, Date_of_accommodation
from bet b
    inner join user u on b.ID_user = u.ID_user
where b.ID_announcement=$ID";
    $bets_result = $connection->query($query);
    $bets = $bets_result->fetch_all(1);
    $data_main = ['categories' => $categories, 'lot' => $announcement, 'bets' => $bets];
    $main = include_path("lot.php", $data_main);
    $data_layout = array_merge(['is_auth' => $is_auth, 'user_name' => $user_name, 'main' => $main, 'page_name' => $announcement['Name']], $data_main);
}
else
{
    $data_main = ['categories' => $categories];
    $main = include_path("404.php", $data_main);
    $data_layout = array_merge(['is_auth' => $is_auth, 'user_name' => $user_name, 'main' => $main, 'page_name' => "404"], $data_main);
}

print include_path("layout.php",$data_layout);

