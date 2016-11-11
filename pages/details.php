
<?php
if(isset($_SESSION['user__Id']))
{
    //if yes
    if (isset($_POST['yes']))
    {
        $mail       =   $_POST['username'];
        $address    =   $_POST['address'];
        $zip        =   $_POST['zip'];
        $city       =   $_POST['city'];
        $country    =   $_POST['country'];

        global $mail;
        global $address;
        global $zip;
        global $city;
        global $country;

        if(isset($mail) && ($address) && ($zip) && ($city) && ($country))
        {
            $stmt = $link->prepare("UPDATE
                                    users
                                    SET
                                    user__Mail
                                    =
                                    $mail,
                                    user__Adress
                                    =
                                    $address,
                                    user__Zip
                                    =
                                    $zip,
                                    user__City
                                    =
                                    $city,
                                    user__Country
                                    =
                                    $country
                                    WHERE
                                    user__Id
                                    = 
                                    $user__Id");
            $stmt->execute();

            $user__Info = [
                "user__mail" => $mail,
                "address" => $address,
                "zip" => $zip,
                "city" => $city,
                "country" => $country
            ];
            $_SESSION['user__Info'] = $user__Info;

            header("location:index.php?page=payment");
        }
        else
        {
            echo "ALL FIELDS MUST BE FILLED!";
        }

    }
    elseif(isset($_POST['no']))
    {
        if(isset($mail) && ($address) && ($zip) && ($city) && ($country))
        {

            $user__Info = [
            "user__mail" => $mail,
            "address" => $address,
            "zip" => $zip,
            "city" => $city,
            "country" => $country
            ];
            $_SESSION['user__Info'] = $user__Info;

            header("location:index.php?page=payment");
        }
        else
        {
            echo "ALL FIELDS MUST BE FILLED!";
        }
    }
   ?>
    <form method="post" class="login__Form hidden" id="verynice">
        <label>Do you wish to overwrite your account details with these?</label>
        <input type="submit" name="yes" value="yes">
        <input type="submit" name="no" value="no">
    </form>
   <?php

    $stmt = $link->prepare("SELECT    
                            user__Mail, 
                            user__Adress,
                            user__Zip,
                            user__City,
                            user__Country
                            FROM
                            users");
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<form method="post" class="login__Form">
    <label class="account__Bound">Email</label>
    <input id="email"type="email" name="username" value="<?php
    echo $data['user__Mail'];
    ?>">
    <label class="account__Bound">Address</label>
    <input type="text" name="address" value="<?php
    echo $data['user__Adress'];
    ?>">
    <label class="account__Bound">Zip</label>
    <input type="text" name="zip" value="<?php
    echo $data['user__Zip'];
    ?>">
    <label class="account__Bound">City</label>
    <input type="text" name="city" value="<?php
    echo $data['user__City'];
    ?>">
    <label class="account__Bound">Country</label>
    <input type="text" name="country" value="<?php
    echo $data['user__Country'];
    ?>">
    <input type="button" class="details" name="accept" value="Continue to payment">
</form>
<?php
}
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 06-09-2016
 * Time: 10:29
 */
?>