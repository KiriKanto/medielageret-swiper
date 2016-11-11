<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 01-09-2016
 * Time: 12:04
 */

class c_database
{
    // My Fields
    //$cart skal kun bruges vis jeg henter fra databasen og ikke session
    private $cart		= array();
    private $user_id	= NULL;
    private $cart_id    = NULL;

    public function __construct()
    {
        global $link;
            //declare user id
            $this->user_id = intval($_SESSION['user__Id']);

            //if cart session cart is set and it contains items
            //we need to insert them into the database.
            if(isset($_SESSION['cart'])  && is_array($_SESSION['cart']) )
            {
                // Loop through products in cart
                foreach($_SESSION['cart'] as $prod_variant_id => $product_data)
                {
                    // Use method to add product
                    $this->add_to_cart($prod_variant_id, $product_data['product_quantity']);
                }
                // Delete SESSION cart
                unset($_SESSION['cart']);
                // Refresh page
                header('Location: index.php');
                exit;
            }
            else
            {
                $stmt     = $link->prepare("SELECT * FROM
                                    cart
                                    WHERE
                                    fk__User__Id = $this->user_id
                                    ");
                $stmt->execute();

                $row            = $stmt->fetch(PDO::FETCH_ASSOC);

                $cart__Id  = $row['cart__Id'];

                $stmt = $link ->prepare("SELECT * FROM
                                        single__product__cart
                                        INNER JOIN
                                        cart
                                        ON 
                                        fk__Cart__Id =
                                        $cart__Id
                                        ");
                $stmt ->execute();
            }
    }
    //__Construct done
    public function add_to_cart($prod_variant_id, $product_quantity)
    {

        global $link;

        $stmt     = $link->prepare("SELECT * FROM
                                    cart
                                    WHERE
                                    fk__User__Id = $this->user_id
                                    ");
        $stmt->execute();

        $row            = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->cart_id  = $row['cart__Id'];

        $stmt = $link ->prepare("SELECT * FROM
                                single__product__cart
                                INNER JOIN
                                cart
                                ON 
                                fk__Cart__Id =
                                $this->cart_id
                                WHERE
                                fk__Prod__Variant__Id
                                = $prod_variant_id
                                ");
        $stmt ->execute();

        $checker = $stmt->fetch(PDO::FETCH_ASSOC);


    //check om produktet allerede existerer i databasen
        if(isset($checker['fk__Prod__Variant__Id']))
        {
            if ($product_quantity > 0)
            {

                if(array_key_exists($prod_variant_id, $checker))
                {

                    $checker['fk__Prod__Variant__Id'][$prod_variant_id]['product_quantity'] += $product_quantity;


                    $stmt = $link->prepare("UPDATE    
                                        single__product__cart
                                        SET
                                        single__Product__Quantity
                                        =
                                        $product_quantity
                                        WHERE 
                                        fk__Prod__Variant__Id
                                        =
                                        $prod_variant_id
                                        ");
                    $stmt->execute();
                }
            }
            else
            {
                $id = $checker['fk__Prod__Variant__Id'];

                $stmt = $link->prepare("DELETE FROM
                                        single__product__cart
                                        WHERE
                                        fk__Prod__Variant__Id
                                        =
                                        $id
                                        ");
                $stmt->execute();
            }

        }
        else
        {
            $stmt     = $link ->prepare("INSERT INTO 
                                single__product__cart
                                  (
                                   single__Product__Quantity,
                                   fk__Cart__Id,
                                   fk__Prod__Variant__Id
                                  ) 
                                  VALUES 
                                  (
                                   $product_quantity,
                                   $this->cart_id,
                                   $prod_variant_id
                                  )");

            $stmt->execute();
        }

    }


    /**
     * @return null
     */
    public function update_cart($prod_variant_id, $product_quantity, $cart_id)
    {

    }
    public function get_cart_from_db()
    {
        global $link;
        $stmt = $link -> prepare("SELECT * FROM 
                              cart
                              INNER JOIN
                              single__product__cart
                              ON 
                              cart.cart__Id 
                              = 
                              single__product__cart.fk__Cart__Id
                              INNER JOIN
                              users
                              ON 
                              cart.fk__User__Id 
                              = 
                              users.user__Id
                              INNER JOIN
                              prod__variant
                              ON 
                              single__product__cart.fk__Prod__Variant__Id 
                              = 
                              prod__variant.prod__Variant__Id
                              INNER JOIN
                              products
                              ON 
                              prod__variant.fk__Prod__Id 
                              = 
                              products.product__Id
                              INNER JOIN
                              variants
                              ON 
                              prod__variant.fk__Variant__Id 
                              = 
                              variants.variant__Id
                              WHERE
                              users.user__Id
                              =
                              cart.fk__User__Id
                             ");
        $stmt->execute();

        $data = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
         $data[] = $row;
        }
        return $data;
    }
    public function empty_db_cart()
    {

    }
}