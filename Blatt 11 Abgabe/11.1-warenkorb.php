<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Warenkorb</title>
    </head>
    <body>
        <h1 align="center"> Willkommen im Warenkorb </h1>
        <a href="11.1-webshop.php"> <h3 align="center"> Zum Webshop </h3></a>
        <a href="11.1-login.php"><h3 align="center">Zum Login</h3><a>
        <?php
            include 'Shop.php';
            session_start();
            // Prüft ob Shop exisitert
            if(isset($_SESSION['shop'])){
                $_SESSION['shop']->display();
            }
            
            
        ?>
        
        
        
    </body>
</html>