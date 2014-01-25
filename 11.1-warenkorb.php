<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Warenkorb</title>
    </head>
    <body>
        <h1 align="center"> Willkommen im Warenkorb </h1>
        <a href="11.1-webshop.php"> <h3 align="center"> Zum Warenkorb </h3></a>
        
        <?php
            // Session und Sessionvariable vom Typ Shop anlegen
            session_start();
            include 'Shop.php';
            $_SESSION['shop'] = new Shop("swa006","swa006","Ahjee9U");
            
            // Elemente aus dem Formular werden in den lokale array item gespeichert
            if($_POST){
                echo "elemente im Array";
            }
            
        ?>
        
        
    </body>
</html>