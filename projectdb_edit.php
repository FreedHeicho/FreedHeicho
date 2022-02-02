<?php
session_start();
include_once("connect.php");

$id=isset($_GET['id']) ? $_GET['id'] : '';
 
    if($id==''){
         $_SESSION['message']="Invalid edit operation!";
         $_SESSION['mType']="error";
         header("location: project_db.php");
         exit();
    }

    $thesql= "SELECT * FROM states where(id=$id)";
    $check= mysqli_query($connect,$thesql);

    if($check ===false){
        $_SESSION['message']="Error acesssing the database! ".mysqli_error($connect);
        $_SESSION['mType']="error";
        header("location: project_db.php");
        exit();
    }
    
    $getTotal=mysqli_num_rows($check);

    if($getTotal <=0){
        $_SESSION['message']="Data to be Edited not found";
        $_SESSION['mType']="error";
        header("location: project_db.php");
        exit();
    }

    mysqli_data_seek($check, 0);
    $row=mysqli_fetch_assoc($check);
    $stateName=$row['statename'];
    $statePopulation=$row['statepopulation'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Population</title>
    <link rel="stylesheet" href="projectstyle.css">
</head>
<body>
<p class="text-center"><a href="project_db.php">Back to States</a></p>
        <h3 class="text-center">Edit to a New State</h3>
        <form id="myform" action="project_db_add_process.php" method="post">
            <table align="center" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr bgcolor="#efefef">
                        <td> <b>Enter State</b> </td>
                        <td> <b>Enter State Population</b> </td>
                    </tr>
                    <tr bgcolor="#a2c4d3">  
                        
                        <td>
                            <input type="text" id="amendStateName" name="amendStateName" autofocus value="<?php echo $stateName?>" />
                        </td>
                        <td  >
                            <input type="text" id="amendStatePolpulation" name="amendStatePolpulation" value="<?php echo $statePopulation?>"/>
                        </td>
                    </tr>
                    <tr bgcolor="#d0d0d0">
                        <td class="text-center" colspan="2">
                            <button type="button" onclick="add_data_click()">
                             Update Data
                            </button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>


  <script language='javascript'>
         function add_data_click(){
          var amendStateName = document.getElementById("amendStateName").value;
          var amendStatePopulation = document.getElementById("amendStatePopulation").value;
          amendStateName = amendStateName.trim();
          amendStatePopulation = amendStatePopulation.trim();

          if (amendStateName == '') {
          alert("Statename is required!");
          document.getElementById("amendStateName").focus();
          return;
         }
          if (amendStatePopulation == '' || isNaN(amendStatePopulation==true)) {
          alert("Enter Population Number for State!");
          document.getElementById("amendStatePopulation").focus();
          return;
         }
          show_loading();
          document.getElementById('myform').submit();

           }

          function show_loading(){

          document.getElementById("message").innerHTML=" <p style='text-align:center; color:green;'><b>Loading...</b></p> ";


           }
  </script> 
</body>
</html>