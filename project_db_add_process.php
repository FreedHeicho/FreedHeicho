<?php
   session_start();
   //error_reporting(E_ALL);
include_once("connect.php");
   
   $newState=isset($_POST['newState']) ? trim($_POST['newState']) : '';
   $newState =strtoupper($newState);
   $newPopulation=isset($_POST['newPopulation']) ? trim($_POST['newPopulation']) : '';
   $newPopulation =strtoupper($newPopulation);

   $add_url="project_db_add.php";
   
   if($newState==''){
       $_SESSION['message']= "State Name is required";
       $_SESSION['mType'] = "error";
       header("location: $add_url");
       exit();
   }
   if($newPopulation==''){
       $_SESSION['message']= " Input State Population";
       $_SESSION['mType'] = "error";
       header("location: $add_url");
       exit();
   }
     
    $thesql="SELECT * from states where(statename='$newState')"; 
    //$hesql= "SELECT * from states where(statepopulation='$newPopulation')";
    $check = mysqli_query($connect,$thesql);
    
    if($check===false){
        $_SESSION['message']= "Error encountered accessing State Data!".mysqli_error($connect);
        $_SESSION['mType'] = "error";
        header("location: $add_url");
        exit();
    }
    $totalCensus= mysqli_num_rows($check);

    if($totalCensus>0){
        $_SESSION['message']= "<b> $newState </b> already exists!";
        $_SESSION['mType']= "error"; 
        header("location: $add_url");
         exit();


    }

    $thesql="INSERT INTO states (statename, statepopulation) value('$newState', $newPopulation)";
   // $thesql="INSERT INTO mynames set name= '$newName'";
    
    $addData=mysqli_query($connect,$thesql);

    if($addData===false){
        $_SESSION['message']= "Error encountered.Add name <b>$newState</b> and <b>$newPopulation</b>".mysqli_error($connect);
        $_SESSION['mType'] = "error";
        header("location: $add_url");
        exit();
    }
    $_SESSION['message']= "New name <b>$newState</b> and Population <b>$newPopulation</b> was successfully added!";
    $_SESSION['mType']="success";
    header("location: project_db.php");
    exit();
?>