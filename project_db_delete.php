<?php 
  session_start();
  include_once("connect.php");
 
  $id=isset($_GET['id']) ? $_GET['id']:'';

  if($id==''){
      $_SESSION['message']="Data to be deleted does not exist";
      $_SESSION['mType']="error";
      header("location: project_db.php");
      return;
  }

  $thesql="SELECT * From states where(id='$id')";
  $check=mysqli_query($connect, $thesql);
  if($check==false){
      $_SESSION['message']="error accessing records".mysqli_error($connect);
      $_SESSION['mType']="error";
      header("location: project_db.php");
      return;
       
   }

   $totalDat= mysqli_num_rows($check);

   if($totalDat<=0){
    $_SESSION['message']="Record to be deleted cannot be found";  
    $_SESSION['mType']="error";
    header("location: project_db.php");
    return;
   }

   mysqli_data_seek($check,0);
   $row=mysqli_fetch_assoc($check);
   
   $stateName=$row['statename'];

  $thesql= "DELETE FROM states where (id='$id')";
  $delete=mysqli_query($connect, $thesql);

  if($delete==false){
      $_SESSION['message']=" Error deleting $stateName from database".mysqli_error($connect);
      $_SESSION['mType']="error";
      header("location: project_db.php");
      return;
  }
      $_SESSION['message']=" Successfully deleted $stateName from database";
      $_SESSION['mType']="success";
      header("location: project_db.php");
      return;
  
    


?>