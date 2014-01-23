<?php
include("ShoppingCartMySQL.php");
class ShoppingCartAuth extends ShoppingCartMySQL
{
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

            } catch (PDOException $e) {
                echo "Fehler: ".$e->getMessage();
            }
        }
        
        function checkAuth($userid, $password){
        
            $hashpass = /**md5(**/$password;
    
            $stmt = $this->db->prepare("SELECT userid, password FROM `user` WHERE userid = :userid AND password = :hashpass ");
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":hashpass", $hashpass);
            $stmt->execute();
            $queryresult = $stmt->fetchObject();
   
            if(empty($queryresult)){
                return false;
            }
                return true;
        }
        
        
        public function createOrder ($userid){
            try {
                $new_number = 0;
                $old_number = 0;
                $new_order_id = "";
                $not_empty = TRUE;
                $year = date("Y");
                // -selects the last numbers
                $sql = 'SELECT MAX(CAST(SUBSTRING(orderid, 6, CHAR_LENGTH(orderid)-5) AS UNSIGNED)) FROM `order`';
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                $old_orderid = $stmt->fetchAll();
                
                if(is_null($old_orderid)){ // if nothing is in the table
                    $new_number = 1;
                    $not_empty = FALSE;
                }
                
                $old_orderid = intval($old_orderid[0][0]);
                //selects the 4 beginning numbers so it will work till year 9999
                $sql_select_year = "SELECT MAX(CAST(SUBSTRING(orderid, 1, 4) AS UNSIGNED)) FROM `order`";
                $stmt = $this->db->prepare($sql_select_year);
                $stmt->execute();
                $old_order_year = $stmt->fetchAll();
                $old_order_year = intval($old_order_year[0][0]);
                
                if (intval($year) == $old_order_year && $not_empty){
                    $new_number = $old_orderid +1; // just increase by one
                }
                
                if($not_empty && $new_number == 0){ // if it is the first in the year 
                    $new_number = 1;
                }
                
                $new_order_id = $year."-".strval($new_number);
                $sql_insert = 'INSERT INTO `order` (`orderid`, `userid`) VALUES(:orderid, :userid)';
                $stmt = $this->db->prepare($sql_insert);
                $stmt->bindParam(':orderid', $new_order_id);
                $stmt->bindParam(':userid', $userid);
                $stmt->execute();
                
                return $new_order_id;
                
            } catch (PDOException $e) {
                echo "Fehler: ".$e->getMessage();
            }

            }
        }

