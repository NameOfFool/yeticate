<?php
require_once "functions.php";//daecNazD ugOGdVMi oixb3aL8
$connection = connection();
$categories = categories($connection);

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email = $_POST['email'];
    $password=$_POST['password'];
    $errors = array();
    $e =0;
    foreach ($_POST as $index=>$value)
    {
        if($value==="")
        {
            $errors[$index]="Введите $index";
            $e=1;
        }
        else
        {
            $errors[$index]=0;
        }
    }
    $query = "SELECT user_name,Password,Avatar from user where Email='$email'";
    $result = $connection->query($query);
    if($result->num_rows===0 && $errors['email']===0)
    {
        $errors['email']="Пользователь с такой почтой не найден";
        $e=1;
    }
    $user = $result->fetch_array();
    if(!password_verify($password,$user['Password']) && $errors['password']===0)
    {
        $errors['password']="Неверный пароль";
        $e=1;
    }
    if(!$e)
    {
        $user_name = $user['user_name'];
        $avatar = $user['Avatar'];
        setcookie('user_name',$user_name);
        setcookie('avatar', $avatar);
        header("location:index.php");
    }
    else
    {
        $main_page = include_path('login.php', ['categories' => $categories,"errors"=>$errors]);
        print_r(
            include_path(
                "layout.php",
                ['categories' => $categories,
                    "main" => $main_page,
                    "page_name" => "Авторизация"]
            )
        );
    }
}
else
{

    $main_page = include_path('login.php', ['categories' => $categories]);
    print_r(
        include_path(
            "layout.php",
            ['categories' => $categories,
                "main" => $main_page,
                "page_name" => "Авторизация"]
        )
    );
}
