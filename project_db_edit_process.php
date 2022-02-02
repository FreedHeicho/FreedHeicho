<?php
   session_start();
   include_once("connect.php");

   $id=isset($_GET['id'])?$_GET['id'] :'';
   
   if($id==''){
       $_SESSION['message']="Invalid Identification";
       $_SESSION['mType']="error";
       header("location : project_db_edit.php");
       exit();
    }

    
    $thesql="SELECT * from states where(id='$id')";
    $check = mysqli_query($connect,$thesql);
 
    if ($check === false){
      $_SESSION['message']="Error accessing records!".mysqli_error($connection);
      $_SESSION['mType']="error";
      header("location: project_db.php");
      exit();
     }
 
     $totalDat= mysqli_num_rows($check);
     
     if($totalDat <= 0){
     $_SESSION['message']="Record to be edited does not exist!";
     $_SESSION['mType']="error";
     header("location: project_db.php");
     exit();
 
     }

      
    mysqli_data_seek($check, 0);

    $row=mysqli_fetch_assoc($check);
    
    $stateName=$row['statename'];

    $statePopulation=$row['statepopulation'];
 
    $newEditedState=isset($_POST['newEditedState']) ? $_POST['newEditedState'] : '';
    $newEditedPopulation=isset($_POST['newEditedPopulation']) ? $_POST['newEditedPopulation']:'';
    $newEditedState=strtoupper($newEditedState);
   
    if($stateName==$newEditedState && $statePopulation==$newEditedPopulation){
      $_SESSION['message']="DATA you want to edit already exists";
      $_SESSION['mType']="error";
      header("location: project_db.php");
      exit();
   }


   $thesql="SELECT * from states where(statename='$newEditedState' and id<>'$id')";
   $validate=mysqli_query($connect,$thesql);

 
  
   if($validate ===false){
       $_SESSION['message']="Error encountered validating New State Name".mysqli_error($connect);
       $_SESSION['mType']='error';
       header("location :project_db.php");
   }
 
      $totalNewData=mysqli_num_rows($validate);
      if($totalNewData >0 ){
           $_SESSION['message']=" The State $newEditedState already exists! Therefore you cannot change $stateName to $newEditedState!";
           $_SESSION['mType']="error";
           header("location: project_db.php");
           exit();
   
       }
  

    $thesql="UPDATE states set statename='$newEditedState',statepopulation='$newEditedPopulation' where(id='$id')";
    $check =mysqli_query($connect, $thesql);

    
    if($check==false){
       $_SESSION['message']="Error accessing Updating data! ".mysqli_error($connect);
       $_SESSION['mType']="error";
       header("location: project_db.php");
       exit();
    }
   
     $_SESSION['message']= "<b>$stateName</b> was successfully updated to <b>$newEditedState</b>";
     $_SESSION['mType'] = 'success';
     header("location: project_db.php");
     exit();

    







   


?>