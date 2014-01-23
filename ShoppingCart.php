<?php
class ShoppingCart
{
	    
	    protected $items;
		public function __construct()
		{
            $items = array();
		}
		
		public function add($name,$price,$quantity)
		{
		    if(!isset($this->items[$name]))
			{
			// $name oder "$name" -> egal "" wertet Var aus in z.B Echo "$name"
		    $this->items[$name]["quantity"] = $quantity;
			$this->items[$name]["price"] = $price;
			echo "Der Artikel $name wurde $quantity mal hinzugefuegt <br/> ";
		    }else{
                  $this->items[$name]["quantity"] += $quantity;
			      echo "Der Artikel $name ist bereit in deinem Warenkorb <br>
                  die quantity wird erhöht";
                  }
                  

		}
		
		public function delete($name,$quantity)
		{
		    if(isset($this->items[$name]))
			{
			    if(($this->items[$name]["quantity"] - $quantity) >= 1 )
			    {
				    $this->items[$name]["quantity"] -= $quantity;
					echo " abgezogen";
				}else{
				    unset($this->items[$name]);
					echo " gelöscht";
				}
		    }else{
			     echo " ".$name. " ist nicht vorhanden";
                 }
		}
		
		public function subtotal()
		{
		   $help = 0;
		   foreach($this->items as $key => $value)
		   {
		       # Summe (anzahl i * preis i)
		       $help += $value["quantity"] * $value["price"]; 
		   }
           
		   return $help;
		
		}
		
		public function display()
		{
		    echo "<table>
				  <caption>Warenkorb</caption>
				  <tr><th>Name</th><th>Anzahl</th><th>Preis</th></tr>";
		    foreach($this->items as $key => $value)
		    { 
                echo 
                     "<tr><td>".$key."</td><td>".$value["quantity"]."</td><td>".$value["price"]."</td></tr>";
		    }
			echo "<tr><td>Summe</td><td></td><td>".self::subtotal()."</td></tr>
			     </table>";
		}
		
	
}       
            


