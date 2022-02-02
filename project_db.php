<?php
 session_start();
 include_once("connect.php");

$message=isset($_SESSION['message']) ? $_SESSION['message'] : '';
$mType = isset($_SESSION['mType']) ? $_SESSION['mType'] : '';

$newsql="SELECT * from states ORDER BY statename ";

$getCensus=mysqli_query($connect, $newsql);

if($getCensus===false){
    die("Error encountered accesing Census Data!".mysqli_error($connect));
}

$totalCensus=mysqli_num_rows($getCensus);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries</title>
    <link rel="stylesheet" href="projectstyle.css">
</head>
<body>
      <div class="wrapper">
          <h1 class= "text-center">
              States in a country
          </h1>
          <div id="message">
          <?php
               if($message !=''){
                   ?>
                   <p class="<?php echo $mType ; ?>">
                             <?php echo $message   ?>   
                  </p>
                   <?php
                   unset($_SESSION['message'], $_SESSION
                   ['mType']);
               }
          ?>
          </div>
          <p class="text-center">
              <a href="project_db_add.php">
                  Add new Data
              </a>
          </p>
           <h3 class="text-center"> State Names and Population :</h3>

           <table align="center" cellpadding="10" cellspacing="0" border="1">
               <tr>
                   <td><b>S/N</b></td>
                   <td><b>State Name</b></td>
                   <td> <b>State Population</b> </td>
               </tr>
               <?php
                for($t=0;$t<$totalCensus; $t++) {
                  $s=$t+1;
                  mysqli_data_seek($getCensus,$t);
                  $row=mysqli_fetch_assoc($getCensus);
                  $currentId=$row['id'];
                  $currentStateName=$row['statename'];
                  $currentStatePopulation=$row['statepopulation']
                  ?>
                  <tr>
                 
                      <td>
                      
                      <?php echo $s; ?></td>
                      <td>
                      <a href="project_db_edit.php?id=<?php echo $currentId ?>" ">
                      <?php echo $currentStateName; ?>
                      </a>
                      </td>
                      <td class="text-right"><?php echo $currentStatePopulation;
                           
                       
                           ?>
                      </td>
                      <td> <input type="button" value="x" title="click to delete State Data" style="cursor: pointer;" onclick="delete_click('<?php echo $currentId ; ?>', '<?php echo $currentStateName; ?>', '<?php echo $currentStatePopulation; ?>')" </td>
                  </tr>
                  <?php
                }      
               ?>

           </table>

      </div>

      <script language='javascript'>
           function show_loading(){
              document.getElementById("message").innerHTML=" <p style='text-align:center; color:green;'><b>Loading...</b></p> ";
           }
       
       
           function delete_click(id,statename,statepopulation){
             var c=confirm("Deleting State: " + statename + " with Population of " + statepopulation + "\n\nClick ok to continue...");
            
              if(c==false){
                return;
            }
         
           show_loading();         
          
           window.location= "project_db_delete.php?id=" + id;


        }
 
      </script>
</body>
</html>