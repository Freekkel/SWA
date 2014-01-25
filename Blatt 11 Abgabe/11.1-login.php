<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Login</title>
    </head>
    <body>
        <?php
            include 'Shop.php';
            // Session wird aufgenommen falls sie existiert
            session_start();
            
        ?>
    
        <h1 align="center"> Willkommen im Login </h1>
        <a href="11.1-warenkorb.php"> <h3 align="center"> Zum Warenkorb </h3></a>
        <a href="11.1-webshop.php"> <h3 align="center"> Zum Webshop </h3></a>
        
        <form action="" method="POST">
            <fieldset>
                <legend> Log in </legend>
                <input name="userid" type="text" value="6" />Userid<br />
                <input name="password" type="text" value="Test" />Password<br />
            </fieldset>
            <input name="check_auth" type="submit" value="log in" />
            <input name="logout" type="submit" value="ausloggen" />
        </form>
        
        <?php
            // Ist man bereits eingeloggt ?
            if(isset($_SESSION['orderid'])){
                echo "Du bist bereits eingeloggt";
            }
        
            if(isset($_POST['check_auth']) && strcmp($_POST['check_auth'],'log in') == 0){
                if(isset($_POST['userid'])){
                    if(isset($_POST['password'])){
                        // Lässt nur Buchstaben und Zahlen in den Feldern zu
                        // Das schließt Injections aus die auf Sonderzeichen angewiesen sind
                        $regexp2 = "/[0-9a-zA-Z]/";
                        if (preg_match($regexp2,$_POST['userid'])&& preg_match($regexp2,$_POST['password'])){
                            $orderid = $_SESSION['shop']->authAndOrder($_POST['userid'], $_POST['password']);
                            $_SESSION['orderid'] = $orderid;
                            echo "Deine orderid lautet: ".$orderid;
                        }
                    }
                }
                
            }
            
             if(isset($_POST['logout']) && strcmp($_POST['logout'],'ausloggen') == 0){
                // Löschen der Sessionvariablen & Sessioncookies & der aktuellen gestarteten Session
                session_unset();
                
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000, $params["path"],
                    $params["domain"], $params["secure"], $params["httponly"]);
                }
                session_destroy();
             }
             
        
        ?>