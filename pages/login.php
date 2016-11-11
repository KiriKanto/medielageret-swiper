<?php
if(isset($_SESSION['user__Id']))
{
    header("Location:index.php?page=account");
}
else
{

    if(isset($_POST['submit']))
    {
        $error_msg = '';

        $name = $_POST['username'];

        $password = $_POST['password'];

        $stmt = $link->prepare("SELECT *
                            FROM 
                            users 
                            WHERE 
                            user__Mail = ?");

        $stmt->bindParam(1, $name, PDO::PARAM_STR);

        $stmt->execute();

        $row	  = $stmt -> fetch(PDO::FETCH_ASSOC);

        $hashedpw = hash('sha256', $password . $row['user__Salt']);

        if( $hashedpw == $row['user__Hash'])
        {
            $user__Id = $row['user__Id'];

            $_SESSION['user__Id'] = $row['user__Id'];

            if(isset($_GET['returnUrl']))
            {
                header('location:' . ROOT . $_GET['returnUrl']);
                $my_cart = new c_cart();

            } else {

                header("Location:". ROOT ."index.php?page=account");
                $my_cart = new c_cart();
            }
        }
        else
        {
            $error_msg = "Incorrect password!";
        }

    }
    if(isset($_POST['CU']))
    {
        header("Location:index.php?page=new__User");
    }
    ?>
    <form method="post" class="login__Form">
        <label>Mail</label>
        <input type="username" name="username" placeholder="Mail">
        <label>Password</label>
        <label><?php
            global $error_msg;
            echo $error_msg;
            ?></label>
        <input type="password" name="password">
        <input type="submit" name="submit" value="Login">
        <label>Dont have an account?</label>
        <input class="no__Move" type="submit" name="CU" value="Create User">
    </form>
    <?php
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 30-08-2016
 * Time: 10:07
 */