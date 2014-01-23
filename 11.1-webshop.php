<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>11.1 Webshop</title>
    </head>
    <body>
        <h1 align="center"> Willkommen im Webshop </h1>
        <a href="11.1-warenkorb.php"> <h3 align="center"> Zum Warenkorb </h3></a>
        
        <form action="11.1-warenkorb.php" method="POST">
            <fieldset>
                <legend>Artikel</legend>
                Hotdog:<input name="Hotdog" type="text" /> Anzahl <br/>
                Ananas:<input name="Ananas" type="text" /> Anzahl
            </fieldset>
        <input name="submit_saving" type="submit" class="add_button" value="add" />
        </form>
        
    </body>
</html>