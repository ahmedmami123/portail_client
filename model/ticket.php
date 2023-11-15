<?php 
require_once 'model/ticket.php';
class _ticket{
    private $db;
    //constructor to initialize private to the database connection
    function __construct($conn)
    {
        $this->db=$conn;
    }
    public function InsertTicketDev($ticket_id,$dev_id){
        try {



    // define sql statement to be executed
    $sql='INSERT INTO dev_ticket (ticket_id,dev_id) VALUES(:ticket_id,:dev_id)';
    //prepare the sql statement to be executuin
    $stmt=$this->db->prepare($sql);
//bin all placeholders to the actual values

$stmt->bindparam(':ticket_id',$ticket_id);

    $stmt->bindparam(':dev_id',$dev_id);
  


//execute statment
$stmt->execute();
return true;          
    
        } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
        }
    }
    public function InsertTicket($clientadmin_id,$type,$titre,$description,$piece_joint,$etat){
        try {

    // define sql statement to be executed
    $sql='INSERT INTO ticket (clientadmin_id,type,titre,description,piece_joint,etat) VALUES(:clientadmin_id,:type,:titre,:description,:piece_joint,:etat)';
    //prepare the sql statement to be executuin
    $stmt=$this->db->prepare($sql);
//bin all placeholders to the actual values

$stmt->bindparam(':clientadmin_id',$clientadmin_id);

    $stmt->bindparam(':type',$type);
    $stmt->bindparam(':titre',$titre);
    $stmt->bindparam(':description',$description);
    $stmt->bindparam(':piece_joint',$piece_joint);
    $stmt->bindparam(':etat',$etat);


//execute statment
$stmt->execute();
return true;          
    
        } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
        }
    }

    //get last ticket
    public function GetLastTicket(){
        try{
            $sql="SELECT id FROM `ticket` ORDER BY `id` DESC LIMIT 1";
            $results=$this->db->query($sql);
            $r = $results->fetch();
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }
    // --------------------- get all ticket -------------
    public function GetallTicket(){
        try{
            $sql="SELECT * FROM ticket";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }


       // --------------------- get all ticket for devloppeur -------------
       public function GetallTicketdev($id){
        try{
            $sql="SELECT * FROM `dev_ticket` ,`ticket` WHERE ticket.id=dev_ticket.ticket_id and dev_ticket.dev_id=$id";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }

        //------------------------get ticket details---------------------//
        public function getTicketDetails($id){
            try{
                $sql="SELECT * FROM `ticket` where id = :id";
                $stmt=$this->db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }}
            // --------------- update ticket option ------------------
               public function updateOptionTicket($id,$type,$etat){
        try {
    $sql = "UPDATE `ticket` SET `type`=:type,`etat`=:etat WHERE id = :id" ;
         $stmt = $this->db->prepare($sql);
  $stmt ->bindparam(':id',$id);
  $stmt ->bindparam(':type',$type);
  $stmt ->bindparam(':etat',$etat);
  $stmt->execute();
  return true;
        } catch (PDOExeption $e) {
           //throw $th;
    echo $e->getMessage();
    return false;
        }
  
    }
    //--------------------- add comment----------------------------------------------
    public function Insertcoment($user_id,$ticket_id,$comment,$upload,$type_com){
        try {

    // define sql statement to be executed
    $sql='INSERT INTO commentaire (user_id,ticket_id,comment,upload,type_com) VALUES(:user_id,:ticket_id,:comment,:upload,:type_com)';
    //prepare the sql statement to be executuin
    $stmt=$this->db->prepare($sql);
//bin all placeholders to the actual values

$stmt->bindparam(':user_id',$user_id);

    $stmt->bindparam(':ticket_id',$ticket_id);
    $stmt->bindparam(':comment',$comment);
    $stmt->bindparam(':upload',$upload);
    $stmt->bindparam(':type_com',$type_com);


//execute statment
$stmt->execute();
return true;          
    
        } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
        }
    }
           //get comment
           public function getComment($id){
            try{
                $sql="SELECT commentaire.type_com ,commentaire.id, commentaire.user_id,commentaire.ticket_id,commentaire.comment,commentaire.upload,user.user_name,user.role, CONCAT( FLOOR(HOUR(TIMEDIFF(NOW(),commentaire.date)) / 24), ' jour ', MOD(HOUR(TIMEDIFF(NOW(),commentaire.date)), 24), ' heure/s ', MINUTE(TIMEDIFF(NOW(),commentaire.date)), ' minutes') as datetime from commentaire ,ticket,user where commentaire.ticket_id=ticket.id and user.id=commentaire.user_id and ticket.id=$id";
                $stmt=$this->db->prepare($sql);
    
                $stmt->execute();
                $result=$stmt->fetchall(PDO::FETCH_ASSOC);

                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

//get comment date
 //delete user
 public function DeleteComment($id){
    try {
        $sql="DELETE from commentaire where id=:id";
    $stmt=$this->db->prepare($sql);
    $stmt->bindparam(':id',$id);
    $stmt->execute();
    return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
// --------- get ticket number dashbord -----------
public function countTicket($_ticket) {
    try {
        $sql = "SELECT COUNT(*) AS column_count FROM ticket";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['column_count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
}



?>