<?php
if(isset($_SESSION['user__Id']))
{
    $user__Var = $_SESSION['user__Id'];

    $stmt = $link ->query("SELECT * FROM users
                           WHERE
                           user__Id = $user__Var");
    $stmt -> execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['save']))
    {
        $username       = $_POST['username'];

        $user__Address  = $_POST['address'];

        $user__Zip      = $_POST['zip'];

        $user__City     = $_POST['city'];

        $user__Country  = $_POST['country'];

        $stmt = $link->prepare("UPDATE users
                                SET
                                user__Mail   = (?),
                                user__Adress = (?),
                                user__Zip    = (?),
                                user__City   = (?),
                                user__Country= (?)
                                WHERE
                                user__Id = $user__Var
                                ");
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $user__Address, PDO::PARAM_STR);
        $stmt->bindParam(3, $user__Zip, PDO::PARAM_STR);
        $stmt->bindParam(4, $user__City, PDO::PARAM_STR);
        $stmt->bindParam(5, $user__Country, PDO::PARAM_STR);

        $stmt -> execute();

        header("location:index.php?page=account");
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("Location:index.php?page=login");
    }
?>
<form method="post" class="login__Form">
    <label class="account__Bound">Email</label>
    <input type="email" name="username" value="<?php
            echo $row['user__Mail'];
        ?>">
    <label class="account__Bound">Address</label>
    <input type="text" name="address" value="<?php
            echo $row['user__Adress'];
        ?>">
    <label class="account__Bound">Zip</label>
    <input type="text" name="zip" value="<?php
            echo $row['user__Zip'];
        ?>">
    <label class="account__Bound">City</label>
    <input type="text" name="city" value="<?php
            echo $row['user__City'];
        ?>">
    <label class="account__Bound">Country</label>
    <input type="text" name="country" value="<?php
            echo $row['user__Country'];
        ?>">
    <input type="submit" name="save" value="Save changes">
    <input type="submit" name="logout" value="Log Out">
</form>
    <!-- TABLE FOR FORMER ORDERS START HERE-->
    <table>
        <thead>
        <tr>
        <th>Order Date</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Delivery Address</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $stmt   = $link->query("SELECT * FROM
                                orders
                                INNER JOIN
                                prod__orders
                                ON 
                                orders.order__Id 
                                =
                                prod__orders.fk__Order__Id
                                INNER JOIN
                                users
                                ON 
                                orders.fk__User__Id 
                                = 
                                users.user__Id
                                WHERE
                                fk__User__Id 
                                =
                                $user__Var");
        $stmt->execute();
        while($orders   =   $stmt->fetch(PDO::FETCH_ASSOC))
        {
            ?>
            <tr>
                <td><?php echo $orders['order__Date'];?></td>
                <td><?php echo $orders['order__Total__Quantity'];?></td>
                <td><?php echo $orders['order__Total'];?></td>
                <td><?php echo $orders['prod__Current__Address'];?></td>
            </tr>
            <?php
        }
            ?>
        </tbody>
    </table>
    <!--TABLE FOR FORMER ORDERS END HERE! -->
<?php
}
else
{
    header("Location:index.php?page=login");
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 24-08-2016
 * Time: 13:03
 */