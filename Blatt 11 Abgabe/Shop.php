<?php
 include 'ShoppingCart.php';
 include("ShoppingCartAuth.php");

 class Shop extends ShoppingCart
    {
        protected $database;
        protected $user;
        protected $password;
        protected $orderid;
        
        public function __construct($database, $user, $password){
            $this->database = $database;
            $this->user = $user;
            $this->password = $password;
            $this->orderid = '';
        }
        
        
        public function authAndOrder($userid, $password){
            // sca Objekt ermöglicht Authenifizierung und Übertragung der Artikel in item in die db
            // durch die Methoden checkAuth() und add()
            $sca = new ShoppingCartAuth($this->database,$this->user,$this->password);
            // Authentifizierung
            
            try{
                
                if(!$sca->checkAuth($userid, $password))
                {
                    echo "Wrong Login";
                    throw new Exception("Wrong login");
                
                }else{
                
                    // Neue Bestellung wird in Datenbank angelegt und zugewiesene oderid gespeichert
                    $this->orderid = $sca->createOrder($userid);
                    $sca->setOrderid($this->orderid);
                    
                    // Von item in die Datenbank
                    // Was ist wenn item leer ist ?
                    if(isset($this->items)){
                          foreach($this->items as $key => $value)
                        {
                            //ruft add() der vaterklasse SC-MYSQL auf
                            $sca->add($key, $value["price"], $value["quantity"]);
                        }
                    }
                    
                    
                    return $this->orderid;
                }
                
            } catch (Exception $e) {
                // "Wrong username and/or password"
                $e->getMessage();
            }
        }
        
        
        // Ist eine Orderid gesetzt wird die Methode von SCAUTH aufgerufen
        // Falls Orderid= "" also leer wertet if($this->orderid) == false
        // und es werden die Methoden für das Lokale Array item der parent-Klasse Shop benutzt
        public function add($name,$price,$quantity){
            if($this->orderid){
                $sca = new ShoppingCartAuth($this->database,$this->user,$this->password);
                $sca->setOrderid($this->orderid);
                $sca->add($name,$price,$quantity);
            }else{
                parent::add($name,$price,$quantity);
            }
        }
        
        public function delete($name,$quantity){
            if($this->orderid){
                $sca = new ShoppingCartAuth($this->database,$this->user,$this->password);
                $sca->setOrderid($this->orderid);
                $sca->delete($name,$quantity);
            }else{
                parent::delete($name,$quantity);
            }  
        }
        
        public function subtotal(){
           if($this->orderid){
                $sca = new ShoppingCartAuth($this->database,$this->user,$this->password);
                $sca->setOrderid($this->orderid);
                return $sca->subtotal();
            }else{
               return parent::subtotal();
            }  
        }
        
        public function display(){
           if($this->orderid){
                $sca = new ShoppingCartAuth($this->database,$this->user,$this->password);
                $sca->setOrderid($this->orderid);
                $sca->display();
            }else{
                parent::display();
            }  
        }
        
    }
