<?php
include("ShoppingCartAuth.php");
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Log in to Webshop</title>
    </head>
    <body>
        <?php
            if(isset($_POST['state'])){
            echo $_POST['state'];
            }
            ?>
        <h1 align="center"> Willkommen im Webshop <br /> Log-in </h1>
        
        <form action="" method="POST">
            <fieldset>
                <legend> Log in </legend>
                <input name="state" type="hidden" value="true" />
                <input name="name" type="text" value="name" /><br />
                <input name="password" type="text" value="password" /><br />
            </fieldset>
        <input name="check_auth" type="submit" value="log in" />
        </form>
        <?php
            if(isset($_POST['state'])){
                $database = 'swa006';
                $user = 'root';
                $password = "";
                $auth = new ShoppingCartAuth($database, $user, $password);
                $check = $auth->checkAuth($_POST['name'], $_POST['password']);
                if($check){
                    echo "success";
                    session_start();
                    $_SESSION['cart'] = new Shop($database, $user, $password);
                    $_SESSION['loggedin'] = true;
                    header("Location: 11.1-webshop.php");
                }
                else
                    echo "fail";
            }
        ?>
    </body>
</html>