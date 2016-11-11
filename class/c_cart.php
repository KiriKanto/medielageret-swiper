<?php
//my class for the structure on my object

//see line 100 for commentary on the more advanced self made stuff.
class c_cart{
    //my fields can also be called "properties" or "attributes"
    private $cart = array();

        //makes the cart.
        //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    
        //constructer is the first method that runs.
        public function __construct()
        {
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                $this->get_cart_from_session();
            } else {
                $this->set_cart_session();
            }
        }

    //set cart session data
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    private function set_cart_session()
    {
        $_SESSION['cart'] = $this -> cart;
    }

    //get the cart data from the php session and store it in class variables
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    private function get_cart_from_session()
    {
        $this -> cart = $_SESSION['cart'];
    }

    //add a product to the cart OR update quantity
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    /**
     * @param array $cart
     */
    public function add_to_cart($prod_variant_id, $product_quantity)
    {
        //says that if the id allready exists I.E we allready have something in the cart of that type. we just add another insted of making a new item.
        if(array_key_exists($prod_variant_id, $this -> cart)) {

            $this -> cart[$prod_variant_id]['product_quantity'] += $product_quantity;

        }
        // says that if we DONT have any item of that type in the cart. we make a new item.
        else{
            $this -> cart[$prod_variant_id]          = array();
            $this -> cart[$prod_variant_id]['product_quantity']		= $product_quantity;
        }
        $this -> set_cart_session();
    }

    //returns the contents of the cart in an array.
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function get_cart()
    {
        return $this -> cart;
    }

    //set the quantity for an item in the cart
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function set_quantity($prod_variant_id, $product_quantity)
    {
        // If product quantity is higher than 0, update the quantity in the cart
        if ($product_quantity > 0)
        {
            $this->cart[$prod_variant_id]['product_quantity'] =  $product_quantity;
            $this->set_cart_session();
        }
        // If product quantity is 0 or lower, run method to remove item from cart
        else
        {
            $this->remove_from_cart($prod_variant_id);
        }
        header("location:index.php?page=cart");
    }

    //removes an item from the cart.
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function remove_from_cart($prod_variant_id)
    {
        unset($this -> cart[$prod_variant_id]);
        $this -> set_cart_session();
    }

    //empties the cart
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function empty_cart()
    {
        unset($_SESSION['cart']);
        header("location:index.php");
    }

    //single product price
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function get_product_total($product_id, $product_price)
    {
        $this -> cart[$product_id]['product_id']        = $product_id;
        $this -> cart[$product_id]['product_price']     = $product_price;
    }

    //total amount in cart
    //the variables within the ( ) are variables that has to be sent with the button from the cart_view or index.php page, they are required to find out what we kind of item we need to add.
    public function get_cart_total()
    {
        $cart_total = 0;

       //make this foreach in the show cart page
        foreach ($this->cart as $key => $value)
        {
            $product_sum = $value['product_price'] * $value['product_quantity'];
            $cart_total += $product_sum;
        }
        return $cart_total;

        //foreach der ligger til en samlet variable
    }

}//end after all code snippets are done
?>
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 09-08-2016
 * Time: 08:27
 */
?>