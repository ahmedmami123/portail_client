<?php 
class _user{
    private $db;
    //constructor to initialize private to the database connection
    function __construct($conn)
    {
        $this->db=$conn;
    }
    public function InsertUser($client_id,$user_name,$first_name,$last_name,$email,$langue,$password,$role){
        try {
            $result=$this->getUserByEmail($email);
            if($result['num']>0){
                return false;
            }
            else{
                $new_password=md5($password.$email);
    // define sql statement to be executed


    $sql='INSERT INTO user (client_id,user_name,first_name,last_name,email,langue,password,role) VALUES(:client_id,:uname,:fname,:lname,:email,:lang,:password,:role)';
    //prepare the sql statement to be executuin
    $stmt=$this->db->prepare($sql);
//bin all placeholders to the actual values
$stmt->bindparam(':uname',$user_name);
$stmt->bindparam(':client_id',$client_id);

    $stmt->bindparam(':fname',$first_name);
    $stmt->bindparam(':lname',$last_name);
    $stmt->bindparam(':email',$email);
    $stmt->bindparam(':password',$new_password);
    $stmt->bindparam(':lang',$langue);
    $stmt->bindparam(':role',$role);

//execute statment
    $stmt->execute();
    return true;
            }
        
        } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
        }
    }

    //Get user by email
    public function getUserByEmail($email){
        try{
            $sql="SELECT count(*) as num FROM user where email= :email";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(':email',$email);

            $stmt->execute();
            $result=$stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //Get user by email
    public function getClientById($id){
        try{
            $sql="SELECT * FROM client where id=$id";
            $stmt=$this->db->prepare($sql);
            // $stmt->bindparam(':email',$email);

            $stmt->execute();
            $result=$stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function GettUser($email,$password){
        try{
            
            $sql="SELECT * FROM user where email=:email and password=:password";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(':email',$email);
            $stmt->bindparam(':password',$password);

            $stmt->execute();
            $result=$stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function GetTousUser(){
    try{
        $sql="SELECT * FROM  `user`, `client` WHERE `user`.`client_id`=`client`.`id`";
        $stmt=$this->db->query($sql);
        // $stmt->bindparam(':id',$id);
        $stmt->execute();
        $result=$stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}
}
public function GetTousUserbyid($id){
    try{
        $sql="SELECT * FROM  `user`, `client` WHERE `user`.`client_id`=`client`.`id`and `user`.`id`=$id";
        $stmt=$this->db->query($sql);
        // $stmt->bindparam(':id',$id);
        $stmt->execute();
        $result=$stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}
}
    public function InsertClient($client_name,$Nom_aberge,$email,$logo,$information){
        try {
            $result=$this->getClientByEmail($email);
            if($result['num']>0){
                return false;
            }
            else{

    // define sql statement to be executed
    $sql='INSERT INTO client (client_name,Nom_aberge,email,logo,information) VALUES(:Cname,:abname,:email,:logo,:info)';
    //prepare the sql statement to be executuin
    $stmt=$this->db->prepare($sql);
//bin all placeholders to the actual values
$stmt->bindparam(':Cname',$client_name);

    $stmt->bindparam(':abname',$Nom_aberge);
    $stmt->bindparam(':email',$email);
    $stmt->bindparam(':logo',$logo);
    $stmt->bindparam(':info',$information);

//execute statment
    $stmt->execute();
    return true;
            }
        
        } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
        }
    }

    //Get user by email
    public function getClientByEmail($email){
        try{
            $sql="SELECT count(*) as num FROM client where email= :email";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(':email',$email);

            $stmt->execute();
            $result=$stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Get client bye email and password
    public function GettClient($email,$password){
        try{
            
            $sql="SELECT * FROM client where email=:email and password=:password";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(':email',$email);
            $stmt->bindparam(':password',$password);

            $stmt->execute();
            $result=$stmt->fetch();
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //
    public function GetallUser(){
        try{
            $sql="SELECT * FROM user";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }
    //get user details
    
public function getUserDetails($id){
    try{
        $sql="SELECT * FROM `user` where id = :id";
        $stmt=$this->db->prepare($sql);
        $stmt->bindparam(':id',$id);
        $stmt->execute();
        $result=$stmt->fetch();
        return $result;
    }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }}
        //get user details
    
public function getClientDetails($id){
    try{
        $sql="SELECT * FROM `client` where id = :id";
        $stmt=$this->db->prepare($sql);
        $stmt->bindparam(':id',$id);
        $stmt->execute();
        $result=$stmt->fetch();
        return $result;
    }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }}

    //get liste client
        public function GetTousClient(){
        try{
            $sql="SELECT * FROM client";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }
    //delete user
    public function DeleteUser($id){
        try {
            $sql="DELETE from user where id=:id";
        $stmt=$this->db->prepare($sql);
        $stmt->bindparam(':id',$id);
        $stmt->execute();
        return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //get user by devloper
    public function GetUserByDevloper(){
        try{
            $sql="SELECT * FROM user where role='devloppeur'";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
        }catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    }
    //Get Devloper Assigner
    public function GetDevloperAssigner($id){
        try{
            $sql="SELECT * FROM dev_ticket, ticket, user WHERE dev_ticket.dev_id = user.id AND ticket.id = dev_ticket.ticket_id AND dev_ticket.ticket_id = $id";
            $results=$this->db->query($sql);
            $r = $results->fetchAll(PDO::FETCH_ASSOC);
            return $r;
            
        
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }}
    //get dev ticket by dev id
        public function getdevticket($id){
            try{
                $sql="SELECT count(*) as num FROM dev_ticket where dev_id= :id";
                $stmt=$this->db->prepare($sql);
                $stmt->bindparam(':id',$id);
    
                $stmt->execute();
                $result=$stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
       
        //delete devloppeur assigner
        public function DeleteDevassigner($id){
            try {
                $sql="DELETE from dev_ticket where id_devticket=:id";
            $stmt=$this->db->prepare($sql);
            $stmt->bindparam(':id',$id);
            $stmt->execute();
            return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
        //  //get dev ticket by dev id
        //  public function getticket_id($id){
        //     try{
        //         $sql="SELECT count(*) as num FROM dev_ticket where id_devticket= :id";
        //         $stmt=$this->db->prepare($sql);
        //         $stmt->bindparam(':id',$id);
    
        //         $stmt->execute();
        //         $result=$stmt->fetch();
        //         return $result;
        //     }catch (PDOException $e) {
        //         echo $e->getMessage();
        //         return false;
        //     }
        // }

        public function getdevByid_dev($id){
            try{
                $sql="SELECT * FROM `dev_ticket` where dev_id = :id";
                $stmt=$this->db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }}
            // ----------- count client ------------
public function countClient($_user) {
    try {
        $sql = "SELECT COUNT(*) AS column_count FROM client";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['column_count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
            // ----------- count dev ------------
public function countDev($_user) {
    try {
        $sql = "SELECT COUNT(*) AS column_count FROM user WHERE user.role='devloppeur'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['column_count'];
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
            // ----------- admin dev ------------
public function adminDev($_user) {
    try {
        $sql = "SELECT COUNT(*) AS column_count FROM user WHERE user.role='admin'";
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

//   ----------------------- dashbord page ---------------------

    

?>