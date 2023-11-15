<?php
require_once 'db/config.php';
require_once 'model/user.php';
require_once 'model/ticket.php';

require_once 'session.php';
require_once 'vendor/autoload.php';

//* ----------------------------- CRUD USER -----------------------------------
     
function addticketPost($_ticket, $twig){
    if(isset($_POST['submit'])){
        $clientadmin_id=$_POST['client'];
        $type=$_POST['type'];
        $titre=$_POST['titre'];
        $description=$_POST['description'];
        $etat="public";
        // $piece=$_POST['piece'];
        $orig_file = $_FILES["piece"]["tmp_name"];
        $ext = pathinfo($_FILES["piece"]["name"], PATHINFO_EXTENSION);
        $target_dir = 'UploadTicket/';
        if($orig_file!=null){
            $piece_joint = "$target_dir$titre.$ext";
        }else{
            $piece_joint =null;
        }
        move_uploaded_file($orig_file,$piece_joint);
        
    $result=$_ticket->InsertTicket($clientadmin_id,$type,$titre,$description,$piece_joint,$etat);
  if ($result) {
    $id=$_ticket->GetLastTicket();
    $ticket_id=$id['id'];
    echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$ticket_id');</script>";

  }

    }
}
function addticketPostAdmin($_ticket, $twig){
    if(isset($_POST['submit'])){
        // $clientadmin_id=$_SESSION['id'];
        $type=$_POST['type'];
        $clientadmin_id=$_POST['client'];

        $titre=$_POST['titre'];
        $description=$_POST['description'];
        $etat=$_POST['etat'];
        // $piece=$_POST['piece'];
        $orig_file = $_FILES["piece"]["tmp_name"];
        $ext = pathinfo($_FILES["piece"]["name"], PATHINFO_EXTENSION);
        $target_dir = 'UploadTicket/';
        if($orig_file!=null){
            $piece_joint = "$target_dir$titre.$ext";
        }else{
            $piece_joint =null;
        }
        move_uploaded_file($orig_file,$piece_joint);
        $check=$_POST['ch'];
      //insert ticket  
    $result=$_ticket->InsertTicket($clientadmin_id,$type,$titre,$description,$piece_joint,$etat);
    
//assigner devloppeur
if ($result) {
    $id=$_ticket->GetLastTicket();
    $ticket_id=$id['id'];
    foreach ($check as $dev_id) {
        # code...
   
    $result1=$_ticket->InsertTicketDev($ticket_id,$dev_id);
}
//relod
echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$ticket_id');</script>";
}
    }
}



function assignerdev($_ticket, $twig,$_user){
    if(isset($_POST['submit'])){
    
        $check=$_POST['ch'];
        $id=$_POST['id'];

        foreach ($check as $dev_id) {
    // $compar=$_user->getdevticket($dev_id);

    $res=$_ticket->InsertTicketDev($id,$dev_id);

        }
       
    

       
    
    // $result2="hhhh";
    }
    
    $result=$_ticket->getTicketDetails($id);
    $id1=$result['clientadmin_id'];
    
        $result0=$_user->getClientDetails($id1);
        $result2=$_user->GetDevloperAssigner($id);
        $result1=$_user->GetUserByDevloper();
 echo $twig->render('ticket_details.html',array( 
    'r'=>$result,
    'r1'=>$result0,
    'result1'=>$result1,

    'result2'=>$result2,
    
        ));
}
// --------------------- ticket liste ----------------------
 //ticket list page
  function ticketListe($_ticket,$twig,$_user)  {
    $id=$_SESSION['id'];
   $res=$_user->getUserDetails($id);
   $dev=$_user->getdevByid_dev($id);

   
    $result=$_ticket->GetallTicket();
    $result1=$_ticket->GetallTicketdev($id);

    echo $twig->render('liste_ticket.html',array(
        'result'=>$result,
        'result1'=>$result1,

        'res'=>$res,
        'dev'=>$dev,



    ));
}
// get tous les ticket 
 //user list page
//   function getTicket(,$twig)  {

//     echo $twig->render('liste_utilisateur.html',array(
        

//     ));
    
// }


// --------------------- dashbord ----------------------
 //dashbord
  function dashbord($twig)  {
    echo $twig->render('dashbord.html',array(
    ));
}
  //ajouter un ticket dev et admin page
  function addTicketDev($twig,$_user)  {
    $result=$_user->GetTousClient();
    $result1=$_user->GetUserByDevloper();

    echo $twig->render('add_ticket_dev.html',array(
        'result'=>$result,
        'result1'=>$result1,

    ));
}
 //ajouter un ticket client page
  function addTicketClient($twig,$_user)  {
    $id=$_SESSION['id'];

    $result=$_user->GetTousUserbyid($id);
    echo $twig->render('add_ticket_client.html',array(
        'result'=>$result
    ));
}

//ticket detail
  function ticketDetails($twig,$_ticket,$_user)  {
    $id=$_GET['id'];
    $user_id=$_SESSION['id'];
    $user=$_user->getUserDetails($user_id);

    $result=$_ticket->getTicketDetails($id);
$id1=$result['clientadmin_id'];

    $result0=$_user->getClientDetails($id1);
    $result2=$_user->GetDevloperAssigner($id);
    $result1=$_user->GetUserByDevloper();
    $comment=$_ticket->getComment($id);

    echo $twig->render('ticket_details.html',array(
        'r'=>$result,
        'r1'=>$result0,
        'result1'=>$result1,
        'comment'=>$comment,
'user_id'=>$user_id,
        
        'result2'=>$result2,
        'user'=>$user,

        
    ));
}

// ticket update option 
function update_ticket_option($_ticket,$twig,$_user)  {
    if(isset($_POST['submit'])){
    $id=$_GET['id'];
    $etat=$_POST['etat'];
    $type=$_POST['type'];
    $res=$_ticket->updateOptionTicket($id,$type,$etat);
    echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$id');</script>";
 
}
}

//----------------------------------------add comment---------------------

function addComment($_ticket,$twig,$_user){
    if(isset($_POST['submit'])){
        $user_id=$_SESSION['id'];
$ticket_id=$_POST['ticket_id'];
        $type_com=$_POST['type'];
        $comment=$_POST['description'];
        $crypt="portail";
        $orig_file = $_FILES["myfile"]["tmp_name"];
        $ext = pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);
        $target_dir = 'UploadComment/';
      
        $min = 1000;
$max = 99999;
$randomnumber= rand($min, $max);
        if($orig_file!=null){
            $upload = "$target_dir$randomnumber.$ext";
        }else{
            $upload =null;
        }
        move_uploaded_file($orig_file,$upload);
        
    $res=$_ticket->Insertcoment($user_id,$ticket_id,$comment,$upload,$type_com);
   
        echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$ticket_id');</script>";

    }
}

function DeleteComment($_ticket)  {
    $id=$_GET['id'];
    $ticket_id=$_GET['ticket_id'];
    $result=$_ticket->DeleteComment($id);
    // header('location:index.php?action=liste_utilisateur');
    echo "<script type='text/javascript'>document.location.replace('index.php?action=detail_ticket&id=$ticket_id');</script>";

  
}
?>

