<?php
require_once "functions.php";
$connection = connection();
$categories = categories($connection);
if(!isset($_COOKIE['user_name']))
{
    $main_page = include_path('403.php',array());
    print_r(
        include_path(
            "layout.php",
            ['categories' => $categories,
                "main" => $main_page,
                "page_name" => "Добавление лота"]
        )
    );
}
else
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $e = false;
        $error = array();
        if ($_FILES['image']['name'] == "" || !exif_imagetype($_FILES['image']['tmp_name'])) {
            $e = true;
            $error['image'] = 1;
        } else {
            $error['image'] = 0;
        }
        foreach ($_POST as $index => $item) {
            $condition =
                $item == "" ||
                $item == "Выберите категорию" ||
                (($index == 'lot-rate' || $index == 'lot-step') && preg_match('/^\d+$/', $item) === 0);
            print_r((checkdate((int)substr($item, 5, 2), (int)substr($item, 9, 2), (int)substr($item, 0, 4))));
            if ($condition) {
                $e = true;
                $error[$index] = 1;
            } else {
                if ($index == 'lot-date') {
                    $now = new DateTime();
                    try {
                        $end = new DateTime($item);
                        if ($end < $now) {
                            $e = true;
                            $error[$index] = 1;
                        } else
                            $error[$index] = 0;
                    } catch (Exception $e) {
                        $e = true;
                        $error[$index] = 1;
                    }

                } else {
                    $error[$index] = 0;
                }
            }
        }
        if ($e) {
            $main_page = include_path('add.php', ['categories' => $categories, 'error' => $error, 'fatal' => true, 'data' => $_POST]);
            print_r(
                include_path(
                    "layout.php",
                    ['categories' => $categories, "main" => $main_page, "page_name" => "Добавление лота"]
                )
            );
        } else {
            $name = $_FILES['image']['name'];
            $to = "img/$name";
            $category = $_POST['category'];
            move_uploaded_file($_FILES['image']['tmp_name'], $to);
            $user_name = $_POST['name'];
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
     '" . $_POST['lot-name'] . "',
     '" . $_POST['message'] . "',
     '" . $to . "',
     '" . $_POST['lot-rate'] . "',
     '" . $_POST['lot-date'] . "',
     '" . $_POST['lot-step'] . "'
    );
    select ID_announcements from announcement where Name='" . $_POST['lot-name'] . "';";
            $connection->multi_query($query);
            $connection->next_result();
            $result = $connection->store_result();
            $ID = $result->fetch_row()[0];
            header("location:lot.php?l=$ID");
        }
    } else {
        $main_page = include_path('add.php', ['categories' => $categories, 'error' => null, 'fatal' => false]);
        print_r(
            include_path(
                "layout.php",
                ['categories' => $categories,
                    "main" => $main_page,
                    "page_name" => "Добавление лота"]
            )
        );
    }
}
