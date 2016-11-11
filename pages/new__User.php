<?php
if(isset($_POST['submit']))
{
    $name 	= $_POST['username'];
    $pw 	= $_POST['password'];
    $salt = generateSalt();
    $hash 	= hash( 'sha256', $pw . $salt);

    //not entirely sure why i have this $row...
    //$row = array('$name', '$salt', '$hash');

    $stmt   = $link->prepare("SELECT user__Mail
                            FROM 
                            users 
                            WHERE 
                            user__Mail = ?");

    $stmt ->bindParam(1, $name, PDO::PARAM_STR);

    $stmt ->execute();

    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    if($check > 0)
    {
        echo "Sorry this email has allready been used";
    }
    else
    {
        $stmt 	= $link-> prepare("INSERT INTO 
                                    users
								   (user__Mail,
									user__Salt, 
									user__Hash,
									fk__Role__Id
									) 
								    VALUES 
								  ('$name',
								   '$salt',
								   '$hash',
								   '1')
								");
        $stmt -> execute();

        $stmt   = $link->prepare("SELECT user__Mail,
                                user__Id
                                FROM 
                                users 
                                WHERE 
                                user__Mail = ?");

        $stmt ->bindParam(1, $name, PDO::PARAM_STR);

        $stmt ->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user__Id'] = $row['user__Id'];

        header("Location:index.php?page=account");
    }


}
?>
<form method="post" class="login__Form">
    <label>Email</label>
    <input type="text"name="username" placeholder="Mail">
    <label>Password</label>
    <input type="password" name="password">
    <input type="submit" name="submit" value="Create">
</form>
<?php
/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 30-08-2016
 * Time: 10:05
 */