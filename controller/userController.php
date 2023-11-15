<?php
require_once 'db/config.php';
require_once 'model/user.php';
require_once 'session.php';
require_once 'vendor/autoload.php';
function Logout($twig) {
    session_destroy();
    // Redirect to the login page using JavaScript
    echo '<script>window.location.replace("index.php?action=Loginpage");</script>';
}
//* ----------------------------- CRUD USER -----------------------------------
function addUser($twig)  {  
    
    echo $twig->render('insert_user.html',array( 
    ));
}
// --------------add user for client ----------------
function addUserClient($twig,$_user)  {  

    $id=$_GET['id'];
    $result=$_user->getClientById($id);
    
    echo $twig->render('insert_user_client.html',array( 
        'r1'=>$result,
    ));
   
}
// --------------end add user for client ----------------
function LoginPage($twig)  {  
    echo $twig->render('login.html',array( 
    ));
}
function addUserPost($_user, $twig){
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $email=$_POST['email'];
        $langue=$_POST['langue'];
        $role=$_POST['role'];
        $password=$_POST['password'];
        
    $result=$_user->InsertUser(null,$username,$nom,$prenom,$email,$langue,$password,$role);
    echo '<script>window.location.replace("index.php?action=liste_utilisateur");</script>';
    }
}
function addUserClientPost($_user, $twig){

// $id=$_GET['id'];
    if(isset($_POST['submit'])){
        
        $client_id=$_POST['client_id'];
        $username=$_POST['username'];
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $email=$_POST['email'];
        $langue=$_POST['langue'];
        $role='contact_client';
        $password=$_POST['password'];
        
    $result=$_user->InsertUser($client_id,$username,$nom,$prenom,$email,$langue,$password,$role);
    echo '<script>window.location.replace("index.php?action=liste_utilisateur");</script>';
    
    }
}
 //user list page
  function getUser($_user,$twig)  {
    $result=$_user->GetTousUser();
    $result1=$_user->GetallUser();

// $id=$result['client_id'];
// $result1=$_user->getClientById(1);

    echo $twig->render('liste_utilisateur.html',array(
        'result'=>$result,
        'result1'=>$result1,
        

    ));
    
}
// --------------------- CRUD CLIENT --------------------------------
function addClient($twig)  {
    echo $twig->render('insert_client.html',array(
    ));
}
function addClientPost($_user, $twig){
    if(isset($_POST['submit'])){
        $client_name=$_POST['clientname'];
        $nom_aberge=$_POST['nomaberge'];
        $email=$_POST['email'];
    
        $orig_file = $_FILES["logo"]["tmp_name"];
        $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $target_dir = 'Uploads/';
        if($orig_file!=null){
            $logo = "$target_dir$email.$ext";
        }else{
            $logo =null;
        }
        move_uploaded_file($orig_file,$logo);
        $description=$_POST['description'];
    $result=$_user->InsertClient($client_name,$nom_aberge,$email,$logo,$description);
   echo $twig->render('insert_client.html',array(
    ));
    }
}
function getClient($_user,$twig)  {
    $result=$_user->GetTousClient();
      echo $twig->render('liste_client.html',array(
      'result'=>$result
      ));
  }
function LoginPost($_user,$twig){
    $email = strtolower(trim($_POST['email']));
$password = $_POST['password'];

    $new_password = md5($password.$email);
    $result = $_user->GettUser($email,$new_password);
    $result1 = $_user->GettClient($email,$new_password);

    if(!$result && !$result1){
        echo $twig->render('Login.html',array(
            'msg'=>"Email or Password incorrect",
            

        ));
    }elseif ($result) {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $result['id'];
        $id=$_SESSION['id'];
        $result=$_user->getUserDetails($id);
    
        // echo $twig->render('insert_user.html',array(
        //     'r'=>$result
        
        // ));
        // header('location:index.php?action=ajouter_utilisateur&id='.$id);
    echo '<script>window.location.replace("index.php?action=ajouter_utilisateur");</script>';

        
    }
    else
    {
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $result1['id'];
    $id=$_SESSION['id'];
    $result1=$_user->getClientDetails($id);
    // echo $twig->render('insert_client.html',array(
    //     'r'=>$result
    
    // ));
    // header('location:index.php?action=ajouter_client&id='.$id);
    echo '<script>window.location.replace("index.php?action=ajouter_utilisateur");</script>';

  
}
}
// ----------------- side bar ---------------------
function sidebar($twig,$_user)  {
    if(isset($_SESSION['id'])){
          
          $id=$_SESSION['id'];
          $result=$_user->getUserDetails($id);
          $result1=$_user->getclientDetails($id);
if($result){
    echo $twig->render('sidebar.html',array(
      
        'r'=>$result,
        'a'=>1
            ));
}else{
    echo $twig->render('sidebar.html',array(
      
        'r'=>$result1,
        'a'=>2
            ));
}
       
   }  
  }

 //client list page
  function clientListe($twig)  {
    echo $twig->render('liste_client.html',array(
    ));
}
// ------------ delete user ----------------
function DeleteUser($_user)  {
    $id=$_GET['id'];
    $result=$_user->DeleteUser($id);
    // header('location:index.php?action=liste_utilisateur');
    echo '<script>window.location.replace("index.php?action=liste_utilisateur");</script>';

  
}
//--------------------delete devloper assigne
function DeleteDevloppeurassigner($_user,$twig,$_ticket)  {
    //id devloppeur
    $id=$_GET['id'];
    //id ticket
$id0=$_GET['id0'];
    $res=$_user->DeleteDevassigner($id);
    // header('location:index.php?action=liste_utilisateur');
//    echo '<script>location.reload();</script>';
        echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$id0');</script>";


//   ----------------------- dashbord page ---------------------

}
?>

