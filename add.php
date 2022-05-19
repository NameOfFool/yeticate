<?php
require_once "functions.php";
$is_auth = 1;
$user_name = "Fool";
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $e = false;
    $error = array();
    if($_FILES['image']['name']==""||!exif_imagetype($_FILES['image']['tmp_name']))
    {
        $e = true;
        $error['image']=1;
    }
    else
    {
        $error['image'] = 0;
    }
foreach ($_POST as $index=>$item){
if($item==""||$item=="Выберите категорию"||(($index=='lot-rate'||$index=='lot-step')&&preg_match('/^\d+$/',$item)===0))
{
    $e = true;
    $error[$index]=1;
}
else{
    $error[$index]=0;
}
}
if($e)
{
    $connection = connection();
    $categories = categories($connection);
    $main_page = include_path('add.php', ['categories' => $categories,'error'=>$error,'fatal'=>true,'data'=>$_POST]);
    print_r(
        include_path(
            "layout.php",
            ['categories' => $categories, "is_auth" => $is_auth, "user_name" => $user_name, "main" => $main_page, "page_name" => "Добавление лота"]
        )
    );
}
else
{
    $name = $_FILES['image']['name'];
    $to ="img/$name";
    $category = $_POST['category'];
    move_uploaded_file($_FILES['image']['tmp_name'],$to);
    $connection = connection();
    $query = "Insert into announcement
    (
     ID_announcements,
     ID_category,
     ID_creator,
     ID_winner,
     Date_of_creating,
     Name,
     Description,
     Image,
     Start_cost,
     Date_of_ending,
     Bet_step
     )
values
    (
     null,
     (SELECT ID_category from category where category.Name='$category'),
     (SELECT ID_user from  user where User_name='$user_name'),
     NULL,
     now(),
     '".$_POST['lot-name']."',
     '".$_POST['message']."',
     '".$to."',
     '".$_POST['lot-rate']."',
     '".$_POST['lot-date']."',
     '".$_POST['lot-step']."'
    );select ID_announcements from announcement where Name='".$_POST['lot-name']."';";
    $connection->multi_query($query);
    $connection->next_result();
    $result = $connection->store_result();
    $ID = $result->fetch_row()[0];
    header("location:lot.php?l=$ID");
}
}
else {
    $is_auth = 1;
    $user_name = "Fool";
    $connection = connection();
    $categories = categories($connection);
    $main_page = include_path('add.php', ['categories' => $categories,'error'=>null,'fatal'=>false]);
    print_r(
        include_path(
            "layout.php",
            ['categories' => $categories,
                "is_auth" => $is_auth,
                "user_name" => $user_name,
                "main" => $main_page,
                "page_name" => "Добавление лота"]
        )
    );
}
