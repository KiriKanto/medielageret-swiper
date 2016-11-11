<?php
// db connect med pdo
$hostname   =   "localhost";
$database   =   "medielageret";
$username   =   "root";
$password   =   "";


try{
    //mysql database
    $link   = new PDO("mysql:host=$hostname;dbname=$database;", $username, $password);
    $link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}
catch (PDOException $ex){
    echo "Fejl: "   .   $ex;
}

session_start();
ob_start();


//Running Simple Select Statements

//  In PDO You can run such queries like this:

//  foreach($db->query('SELECT * FROM table') as $row)
// {
//        echo $row['field1'].' '.$row['field2']; //etc...
// }

//query() method returns a PDOStatement object. You can also fetch results this way:

//$stmt = $db->query('SELECT * FROM table');

//while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//    echo $row['field1'].' '.$row['field2']; //etc...
//}

//or

//$stmt = $db->query('SELECT * FROM table');
//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//use $results


/**
 * Created by PhpStorm.
 * User: 110230
 * Date: 17-08-2016
 * Time: 10:30
 */
?>