<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Webshop</title>
    </head>
    <body>
        <?php
            include 'Shop.php';
            // Session wird angelegt
            session_start();
            
        ?>
    
        <h1 align="center"> Willkommen im Webshop </h1>
        <a href="11.1-warenkorb.php"> <h3 align="center"> Zum Warenkorb </h3></a>
        <a href="11.1-login.php"><h3 align="center">Zum Login</h3><a>
        
        <!-- action="" sendet die Formulardaten an sich selbst -->
        <form action="" method="POST">
            <fieldset>
                <legend>Artikel</legend>
                Hotdog:<input name="Hotdog" type="text" /> Anzahl Preis 2 Euro <br/>
                Ananas:<input name="Ananas" type="text" /> Anzahl Preis 1 Euro
            </fieldset>
        <input name="addButton" type="submit" value="zum Warenkorb hinzufuegen" />
        <input name="deleteButton" type="submit" value="aus dem Warenkorb entfernen" />
        </form>
        
        
        <?php
                   if(!isset($_SESSION['shop'])){
                        $_SESSION['shop'] = new Shop("swa006","swa006","Ahjee9U");
                    }
                    
                    // Falls Benutzer eingeloggt ist wird auf Datenbank gearbeitet
                    if(isset($_SESSION['eingeloggt'])&& $_SESSION['eingeloggt']){
                    
                    
                    // Arbeitet auf dem lokalen Array
                    }else{
                        if(isset($_POST['addButton']) && strcmp($_POST['addButton'],'zum Warenkorb hinzufuegen') == 0){
                            // Erlaubt nur positive Zahlen in den Eingabefeldern
                            if(!empty($_POST['Hotdog']) && is_numeric($_POST['Hotdog']) && $_POST['Hotdog'] > 0){
                                $_SESSION['shop']->add('Hotdog',2,$_POST['Hotdog']);
                            }
                            if(!empty($_POST['Ananas']) && is_numeric($_POST['Ananas']) && $_POST['Ananas'] > 0){
                                $_SESSION['shop']->add('Ananas',1,$_POST['Ananas']);
                            }

                        }
                        if(isset($_POST['deleteButton']) && strcmp($_POST['deleteButton'],'aus dem Warenkorb entfernen') == 0){
                            if(!empty($_POST['Hotdog']) && is_numeric($_POST['Hotdog']) && $_POST['Hotdog'] > 0){
                                // Löscht die Artikel aus dem lokale Array item
                                $_SESSION['shop']->delete('Hotdog',2,$_POST['Hotdog']);
                            }
                            if(!empty($_POST['Ananas']) && is_numeric($_POST['Ananas']) && $_POST['Ananas'] > 0){
                                $_SESSION['shop']->delete('Ananas',1,$_POST['Ananas']);
                            }
                        }
                        
                    }
                    
                    
                    

            
        ?>
        
    </body>
</html>