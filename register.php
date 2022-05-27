<?php
require_once "functions.php";
$connection = connection();
$categories = categories($connection);
if($_SERVER['REQUEST_METHOD']=="POST")
{

    $errors = array();
    $e =0;
    foreach ($_POST as $index=>$value)
    {
        $i =$index;
        if($index == "name")
            $i ="имя";
        if($index == "password")
            $i ="пароль";
        if($value==="")
        {
            $errors[$index]="Введите $i";
            $e=1;
        }
        else
        {
            $errors[$index]=0;
        }
    }
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)&&$errors['email']===0)
    {
        $errors['email']="Почта не соответствует формату";
        $e=1;
    }
    $query = "SELECT user_name from user where Email='{$_POST['email']}'; SELECT user_name from user where  User_Name='{$_POST['name']}'";
    $connection->multi_query($query);
    $result1 =$connection->store_result();
    $result = $result1->fetch_array(MYSQLI_ASSOC);
    if($result1->num_rows!==0 && $errors['email']===0)
    {
        $errors['email']="Пользователь с такой почтой уже зарегистрирован";
        $e=1;
    }
    $connection->next_result();
    $result1 =$connection->store_result();
    $result = $result1->fetch_array(MYSQLI_ASSOC);
    if($result1->num_rows!==0 && $errors['name']===0)
    {
        $errors['name']="Пользователь с таким именем уже зарегистрирован";
        $e=1;
    }
    $file = $_FILES['image']['tmp_name'];
    $to = "img/{$_FILES['image']['name']}";
    if($file=="")
    {
        $file = "img/user.png";
        $to = $file;
    }
    else
    {
        $mime = mime_content_type($file);
        if ($mime != 'image/jpeg' && $mime != 'image/png') {
            $errors['image'] = 'Выберите файл формата .png,.jpg,.jpeg';
            $e = 1;
        }
        else {
            if(!$e)
                move_uploaded_file($_FILES['image']['tmp_name'],$to);
        }
    }
    if(!$e)
    {
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
       $query = "INSERT INTO user values (NULL,now(),'{$_POST['email']}','{$_POST['name']}','$password','$to','{$_POST['message']}')";
        $connection->query($query);
        print_r($_FILES);
        $user_name = $_POST['name'];
        $avatar = $to;
        setcookie('user_name',$user_name);
        setcookie('avatar', $avatar);
        header("location:index.php");
    }
    else
    {

        $main_page = include_path('register.php', ['categories' => $categories,"errors"=>$errors]);
        print_r(
            include_path(
                "layout.php",
                ['categories' => $categories,
                    "main" => $main_page,
                    "page_name" => "Регистрация"
                ]
            )
        );
    }
}
else
{

    $main_page = include_path('register.php', ['categories' => $categories]);
    print_r(
        include_path(
            "layout.php",
            ['categories' => $categories,
                "main" => $main_page,
                "page_name" => "Регистрация"
            ]
        )
    );
}
$connection->close();
