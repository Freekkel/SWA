<?php

class ShoppingCartMySQL
{
    protected $db;
    protected $orderid;
    
    /**
     * Konstruktor
     * Verbindung zur Datenbank
     * Exceptions ermöglichen
     * UTF-8 einstellen
     */
    public function __construct($database, $user, $password) 
    {
        try {
            $this->db = new PDO ("mysql:host=localhost; dbname=$database", $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
            //UTF-8 Aktivierung
            $sql = $this->db->prepare('SET NAMES utf8');
            $sql->execute();
            $sql = $this->db->prepare('SET CHARACTER SET utf8');
            $sql->execute();
        } catch (PDOException $ex) {
            echo "Fehler: ".$e->getMessage();
        }
    }
    /**
     * Setzt die OrderID
     *
     * @param string $orderid
     *
     * @return void
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    }
    /**
     * Fügt einen Artikel in den Einkaufswagen hinzu
     *
     * @param string $name Artikelname
     * @param float  $price Preis des Artikels
     * @param int    $quantity Menge des Artikels
     *
     * @return void
     */
    public function add($name, $price, $quantity)
    {
        try {
            $sql = 'SELECT * FROM `item` WHERE name=:name and orderid=:orderid'; 
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':orderid',$this->orderid);
            $statement->execute();
            //Der Artikel befindet sich schon im Warenkorb
            //-> erhöhe Anzahl des Artikels
            if($object = $statement->fetchObject()) {
                $sql = 'UPDATE item SET quantity=:quantity+quantity 
                    WHERE name=:name and orderid=:orderid';
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':quantity', $quantity);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':orderid',$this->orderid);
                $statement->execute();
            //Der Artikel muss dem Warenkorb neu hinzugefügt werden
            } else {
                $sql = 'INSERT INTO item VALUES(:orderid, :name, :quantity, :price)';
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':orderid',$this->orderid);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':quantity', $quantity);
                $statement->bindParam(':price', $price);
                $statement->execute();
            }
        } catch (PDOException $e) {
            echo "Fehler: ".$e->getMessage();
        }
    }
    /**
     * Entfernt einen Artikel aus dem Einkauswagen
     *
     * @param String $name Artikelname
     * @param String $quantity Anzahl der zu entfernenden Artikel
     * 
     * @return void
     */
    public function delete($name, $quantity)
    {
        try {
            $sql = 'SELECT * FROM item WHERE name=:name and orderid=:orderid';
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':orderid',$this->orderid);
            $statement->execute();
            //der Artikel befindet sich bereits im Warenkorb
            if($object = $statement->fetchObject()) {
                //verringere Anzahl des Artikels
                if($object->quantity > $quantity) {
                    $sql = 'UPDATE item SET quantity=quantity-:quantity
                        WHERE name=:name and orderid=:orderid';
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':quantity', $quantity);
                    $statement->bindParam(':name', $name);
                    $statement->bindParam(':orderid',$this->orderid);
                    $statement->execute();
                //entferne den Artikel komplett    
                } else {
                    $sql = 'DELETE FROM item WHERE name=:name AND orderid=:orderid';
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':name', $name);
                    $statement->bindParam(':orderid',$this->orderid);
                    $statement->execute();
                }
            }
        } catch (PDOException $ex) {
            echo "Fehler: ".$e->getMessage();
        }
    }
    /**
     * Berechnet die Summe der Preise im Einkauswagen
     *
     * @return int Summe der Preise
     */
    public function subtotal()
    {
        try {
            $total = 0;
            $sql = 'SELECT price,quantity FROM item WHERE orderid= :orderid';
            $statement = $this->db->prepare($sql);
            $statement->bindparam(':orderid',$this->orderid);
            $statement->execute();
            //gehe jeden Artikel durch
            while($object = $statement->fetchObject()) {
                $total += $object->price * $object->quantity;
            }
            return round($total, 2);
        } catch (PDOException $ex) {
            echo "Fehler: ".$e->getMessage();
        }
    }
    /**
     * Gibt den vollständigen Einkaufswagen in einer HTML5-Tabelle aus
     *
     * @return void
     */
    public function display()
    {
        try {
            $sql = 'SELECT * FROM item WHERE orderid = :orderid';
            $statement = $this->db->prepare($sql);
            $statement->bindparam(':orderid',$this->orderid);
            $statement->execute();
            echo "<table border='1' style='text-align:left'>\n";
            echo "<caption>Einkaufswagen</caption>\n";
            echo "<tr>\n<th>Bestell-Nummer</th>\n<th>Artikel</th>\n<th>Anzahl</th>\n<th>Stückpreis</th>\n</tr>\n";
            while($object = $statement->fetchObject()) {
                echo "<tr>\n<td>".$object->orderid."</td>\n<td>".$object->name."</td>\n<td style='text-align:center'>".$object->quantity.
                    "</td>\n<td style='text-align:right'>".$object->price." &euro;</td>\n</tr>\n";
            }
            echo "<tr>\n<td>Gesamtpreis:</td>\n<td colspan='3' style='text-align:right'><b>".
                $this->subtotal()." &euro;</b></td>\n";
            echo "</table>\n";
        } catch (PDOException $e) {
            echo "Fehler: ".$e->getMessage();
        }
    }
}

