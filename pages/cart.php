<?php
if (isset($_SESSION['user__Id']))
{
    $cart_total = 0;

    $variantPrices = [];

    $data = $my_db -> get_cart_from_db();

    foreach($data as $row)
    {
        $variantPrices[$row['prod__Variant__Id']] = $row['prod__Variant__Price'];

        $price = $variantPrices[$row['prod__Variant__Id']];

        $cart_total += $price * $row['single__Product__Quantity'];
    }
    if(isset($_POST['empty_cart']))
    {
        $my_db->empty_db_cart();
    }
    if(isset($_POST['update_cart']))
    {
        $product__Quantity = $_POST['product_quantity'];

        $product__Id       = $_POST['prod__Variant__Id'];

        $_SESSION['quantity'] = $product__Quantity;

        $my_db->add_to_cart($product__Id, $product__Quantity);

        header("location:index.php?page=cart");

    }
    if(isset($_POST['purchase']))
    {
        header("location:index.php?page=details");
    }
    ?>
    <form method="post">
        <input type="submit" name="empty_cart" value="Empty cart">
    </form>
    <table class="cart">
    <tr class="cart">
        <th class="cart">Total of cart: <?php echo $cart_total; ?></th>
        <th class="cart">VAT of total: <?php ?></th>
        <th class="cart">Total incl VAT: <?php ?></th>
        <th class="cart">

                <form id="payment" method="post">
                    <input type="submit" name="purchase" value="To Payment">
                </form>
        </th>
    </tr>
    <tr class="cart">
        <th class="cart">Product name: </th>
        <th class="cart">Quantity</th>
        <th class="cart">Price total</th>
        <th class="cart">Price per item</th>
    </tr>
    <?php
        $data = $my_db -> get_cart_from_db();

    foreach($data as $cart_content)
    {
        $quantity = $cart_content['single__Product__Quantity'];
        $variantId = $cart_content['fk__Prod__Variant__Id'];

            ?>
            <tr class="cart">
                <td class="cart"><?php echo $cart_content['product__Name'] . ": <br>" . $cart_content['variant__Name']; ?> </td>
                <td class="cart product__Quantity">
                    <form method="post">
                        <input type="number" name="product_quantity" value="<?php echo $quantity;
                        ?>">
                        <input type="submit" name="update_cart" value="Update">
                        <input type="hidden" name="product_price" value="<?php echo $cart_content['prod__Variant__Price'];
                        ?>">
                        <input type="hidden" name="product_name" value="<?php echo $cart_content['product__Name']; ?>">
                        <input type="hidden" name="prod__Variant__Id" value="<?php echo $cart_content['fk__Prod__Variant__Id'];
                        ?>">
                    </form>
                </td class="cart">
                <td class="cart"><?php
                 echo
                 $cart_content['prod__Variant__Price']
                 *
                 $quantity;
                 ?>
                </td>
                <td class="cart"><?php echo $cart_content['prod__Variant__Price'];
                    ?>
                </td>
            </tr>
            <?php
    }
        ?>
        </table>
        <?php

}
elseif(count($my_cart -> get_cart() ) > 0)
{
        //implode array keys til at sende 'keys' i arrayet ud komma seperaret
    $keys = implode(', ', array_keys($_SESSION['cart']));
    //select stuff from database using the prod__Variant__Id we set into the class
    $stmt = $link -> prepare("SELECT * FROM 
                                  prod__variant
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
                                  prod__Variant__Id
                                  IN 
                                  ($keys)");
    $stmt->execute();

    $cart_total = 0;

    $variantPrices = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $variantPrices[$row['prod__Variant__Id']] = $row['prod__Variant__Price'];
    }

    foreach($my_cart->get_cart() as $variantId => $product)
    {
        $price = $variantPrices[$variantId];

        $cart_total += $price * $product['product_quantity'];
    }
    if(isset($_POST['empty_cart']))
    {
        $my_cart->empty_cart();
    }
    if(isset($_POST['update_cart']))
    {
        $product__Quantity = $_POST['product_quantity'];

        $product__Id       = $_POST['prod__Variant__Id'];

        $my_cart->set_quantity($product__Id,$product__Quantity);
        //tror det er her jeg skal ligge i databasen
    }
    ?>
    <form method="post">
        <input type="submit" name="empty_cart" value="Empty cart">
    </form>
    <table class="cart">
        <tr class="cart">
            <th class="cart">Total of cart: <?php echo $cart_total; ?></th>
            <th class="cart">VAT of total: <?php ?></th>
            <th class="cart">Total incl VAT: <?php ?></th>
            <th class="cart">
                <?php
                if(!isset($_SESSION['user__Id'])) {
                    echo "<button><a href='index.php?page=login&returnUrl=index.php?" . $_SERVER['QUERY_STRING']
                        . "'>Log in to continue</a></button>";
                }
                ?>
            </th>
        </tr>
        <tr class="cart">
            <th class="cart">Product name: </th>
            <th class="cart">Quantity</th>
            <th class="cart">Price total</th>
            <th class="cart">Price per item</th>
        </tr>
      <?php
      if(!empty($_SESSION['cart'])) {
          //implode array keys til at sende 'keys' i arrayet ud komma seperaret
          $keys = implode(', ', array_keys($_SESSION['cart']));
          //select stuff from database using the prod__Variant__Id we set into the class
          $stmt = $link->prepare("SELECT * FROM 
                                  prod__variant
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
                                  prod__Variant__Id
                                  IN 
                                  ($keys)");
          $stmt->execute();
          while ($cart_content = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $quantity = $my_cart->get_cart();
              $variantId = $cart_content['prod__Variant__Id'];

              ?>
              <tr class="cart">
                  <td class="cart"><?php echo $cart_content['product__Name'] . ": <br>" . $cart_content['variant__Name']; ?> </td>
                  <td class="cart product__Quantity">
                      <form method="post">
                          <input type="number" name="product_quantity" value="<?php echo $quantity[$variantId]['product_quantity']; ?>">
                          <input type="submit" name="update_cart" value="Update">
                          <input type="hidden" name="product_price" value="<?php echo $cart_content['prod__Variant__Price']; ?>">
                          <input type="hidden" name="product_name" value="<?php echo $cart_content['product__Name']; ?>">
                          <input type="hidden" name="prod__Variant__Id" value="<?php echo $cart_content['prod__Variant__Id']; ?>">
                      </form>
                  </td class="cart">
                  <td class="cart"><?php echo $cart_content['prod__Variant__Price'] * $quantity[$variantId]['product_quantity']; ?>
                  </td>
                  <td class="cart"><?php echo $cart_content['prod__Variant__Price']; ?>
                  </td>
              </tr>
              <?php
          }
          ?>
          </table>
          <?php
      }

}
else
{
    echo "<p>The cart is empty</p>";
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 25-08-2016
 * Time: 09:44
 */
?>