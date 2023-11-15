
<?php 

$host ='127.0.0.1';
$db='portail_db';
$user='root';
$pass='';
$charset='utf8mb4';
$dsn="mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo=new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e) {
    throw new PDOException($e->getMessage());
}
require_once 'model/user.php';


$_user=new _user($pdo);
require_once 'model/ticket.php';


$_ticket=new _ticket($pdo);
// $_user->InsertUser(1,"admin","admin","admin","admin@gmail.com","admin","admin","admin");
//
?>
