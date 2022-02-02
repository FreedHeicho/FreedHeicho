<?php
   session_start();
   include_once("connect.php");

   $message=isset($_SESSION['message']) ? $_SESSION['message'] : '';
   $mType = isset($_SESSION['mType']) ? $_SESSION['mType'] : '';

   $id=isset($_GET['id'])? $_GET['id'] : '';
      
   
   if($id==''){
        $_SESSION['message']="Invalid edit operation";
        $_SESSION['mType']= "error";
        header("location: project_db.php");
        exit;
        }
       

    $thesql="SELECT * FROM states where(id='$id')";
    $check = mysqli_query($connect,$thesql);

    if($check === false){
        $_SESSION['message']= "There was an error accessing database!".mysqli_error($connect);
        $_SESSION['mType']= "error";
        header("location: project_db.php");
        exit();

    }
    $totalRow= mysqli_num_rows($check);

    if($totalRow <= 0){
        $_SESSION['message']="Records to be edited was not found";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing Population Data</title>
    <link rel="stylesheet" href="projectstyle.css">
</head>

<body>

    <div class="wrapper">
       <h1 class="text-center">Edit Country Population</h1>
         <div id="message">
              <?php
              if($message !=''){
                  ?>
                  <p class= "<?php echo $mType; ?>">;
                  <?php
                      echo $message;
                   ?>                  
                  </p>
                  <?php
                  unset($_SESSION['message'],$_SESSION['mType'] );
              }        
              ?>
         </div>

         <p class="text-center">
                <a href="project_db.php"> Back to Country Data</a> 

         </p>
         <h3 class="text-center"> Editing State Data </h3>

         <form id="myform"  action=" project_db_edit_process.php?id=<?php echo $id; ?>" method='post'>
             <table align="center" cellpadding="10" cellspacing="1">
                  <tbody>
                      <tr bgcolor="#efefef">
                          <td> <b>Enter State</b> </td>
                          <td> <b>Enter State Population</b> </td>
                      </tr>
                      <tr>  
                        
                          <td>
                              <input type="text" id="newEditedState" name="newEditedState" autofocus value="<?php echo $stateName?>" autocomplete="off"/>
                          </td>
                          <td  >
                              <input type="text" id="newEditedPopulation" name="newEditedPopulation" value="<?php echo $statePopulation?>" />
                          </td>
                      </tr>
                      <tr bgcolor="#d0d0d0">
                          <td class="text-center" colspan="2">
                              <button type="button" onclick="update_population_data()">
                               Update
                              </button>
                          </td>

                      </tr>
                  </tbody>
             </table>
        </form> 
    </div>

    <script langauge='javascript'>
       function update_population_data(){
          var newEditedState=document.getElementById("newEditedState").value;
          var newEditedPopulation=document.getElementById("newEditedPopulation").value;

          newEditedPopulation= newEditedPopulation.trim();
          newEditedState= newEditedState.trim();
        
          if(newEditedState=='' ){
              alert("Please Enter State Name")
              document.getElementById("newEditedState").focus();
              return;
          }
          
          if(newEditedPopulation== '' || isNaN(newEditedPopulation)==true)
          {
              alert("Enter Appropraite integer for population data")
              document.getElementById("newEditedPopulation").focus();
              return;
          }
          show_loading();
          document.getElementById("myform").submit();
      }

      function show_loading()
        {
        document.getElementById("message").innerHTML= "<p style='text-align:center; color:green;'><b>Loading...</b></p>";
        }
    </script>
</body>
</html>