<?php
require_once 'controller/userController.php' ;
require_once 'controller/ticketController.php' ;

require_once 'vendor/autoload.php';
include_once 'session.php';
$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader);

if (isset($_GET['action'])) {
  sidebar($twig,$_user);
    $action = $_GET['action'];
    switch ($action) {
      //---------------------------------user--------------------------------------//
      //login
      case 'Loginpage';
        LoginPage($twig);
        break;
      case 'Login';
        LoginPost($_user,$twig);
        break;
        //logout
        case 'LogOut';
          Logout($twig);
          break;
        //user 
        case 'addUser';
        addUserPost($_user,$twig);
        break;
        case 'addUserClient';
          addUserClientPost($_user, $twig);
          break;
          case 'ajouter_utilisateur';
          addUser($twig);
        break;
        // ------------- add user for client -----------
         case 'ajouter_utilisateur_client';
          addUserClient($twig,$_user);
        break;
        case 'DeleteUser';
          DeleteUser($_user);
          break;
            //client list page
         case 'liste_utilisateur';
          getUser($_user,$twig);
        break;
    
      case 'assignerdev';
      assignerdev($_ticket, $twig,$_user);
  
         break;  
         case 'Delassignerdev';
         DeleteDevloppeurassigner($_user,$twig,$_ticket);
     
            break; 
        // -----------client---------------
          // ajouter client 
           case 'addClient';
            addClientPost($_user,$twig);
        break; 
          case 'ajouter_client';
           addClient($twig) ;
        break;
         //ajouter ticket client page
         case 'ajouter_ticket_client';
           addTicketClient($twig,$_user) ;
        break;
         //client list page
         case 'liste_client';
          getClient($_user,$twig);
        break;
        // ----------- dev et admin --------------
        //ajouter ticket dev page
         case 'ajouter_ticket_dev';
           addTicketDev($twig,$_user,$_ticket);
        break;   
             case 'update_option_ticket';
        update_ticket_option($_ticket,$twig,$_user); 
            break; 
        //------------------------------------ticket-------------------------------//
              // ajouter un ticker 
        case 'addticket';
          addticketPost($_ticket,$twig);
       break;
          // ajouter un ticker for admin 
          case 'addticketAdmin';
            addticketPostAdmin($_ticket, $twig);
         break;   
      //  ticket liste 
       //ticket list page
         case 'liste_ticket';
          ticketListe($_ticket,$twig,$_user);
        break;
          //ticket details
         case 'detail_ticket';
          ticketDetails($twig,$_ticket,$_user) ;
        break;
        //add comment
        case 'AddComment';
        addComment($_ticket,$twig,$_user) ;
      break;
        //add comment
        case 'DeleteComment';
        DeleteComment($_ticket);
      break;
        // ----------------------- dashbord ----------------------------
  case 'dashbord';
          dashbord($twig,$_user,$_ticket);
        break;
    }
}
else{
echo $twig->render('login.html',array(
));
}
/*/hhhhhhhhhhhh*/
?>