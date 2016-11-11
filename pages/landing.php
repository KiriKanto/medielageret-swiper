<div id="slide__Box">
    <!--slide box start-->
    <div class="swiper-container">
        <!--slider class start-->
        <div class="swiper-wrapper">

            <?php
            $stmt = $link->query('SELECT * FROM products');

            while($row  = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <div class="swiper-slide">
                    <a href="index.php?page=specific__Product&id=<?php echo $row['product__Id']; ?>"><img src="product__Img/<?php echo $row['product__Img']; ?>"></a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <!--slider class end-->
</div>
<?php
if(isset($_POST['login']))
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

        header("Location:index.php?page=account");
    }
    else
    {
        $error_msg = "Incorrect password!";
    }

}
?>
<!--slide box end-->
<?php
if(isset($_SESSION['user__Id']))
{
?>
    <div id="Frontpage__Loginform"></div>
    <?php
}
else
{
    ?>
<div id = "Frontpage__Loginform" >
    <!--login form start-->
    <form method = "post" id = "form__frontpage" >
        <input type = "text" name = "username" placeholder = "Username" >
        <label ><?php
            global $error_msg;
            echo $error_msg;
            ?></label>
<input type="password" name="password" placeholder="password">
<input type="submit" name="login" value="Login">
<br>
    <a href="index.php?page=new__User">Dont have an account?</a>
    </form>
    </div>
<!--login form end-->
<?php
}
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 17-08-2016
 * Time: 10:33
 */
?>