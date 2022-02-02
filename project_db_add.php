<?php
session_start();
$message=isset($_SESSION['message']) ? $_SESSION['message'] : '';
$mType = isset($_SESSION['mType']) ? $_SESSION['mType'] : '';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State Population</title>
    <link rel="stylesheet" href="projectstyle.css">
</head>

<body>
    <div class="wrapper">
        <h1 class="text-center">States</h1>
         <div id="message">
          <?php
              if($message != ''){
                  ?>
                   <p class="<?php echo $mType ; ?>"> 
                   
                      <?php echo $message; ?></p>
                  <?php
                  unset($_SESSION['message'], $_SESSION['mType']);
              }
          ?>
         </div>
        <p class="text-center"><a href="project_db.php">States</a></p>
        <h3 class="text-center">Add a New State</h3>
        <form id="myform" action="project_db_add_process.php" method="post">
            <table align="center" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr bgcolor="#efefef">
                        <td> <b>Enter State</b> </td>
                        <td> <b>Enter State Population</b> </td>
                    </tr>
                    <tr>  
                        
                        <td>
                            <input type="text" id="newState" name="newState" autofocus />
                        </td>
                        <td  >
                            <input type="text" id="newPopulation" name="newPopulation" />
                        </td>
                    </tr>
                    <tr bgcolor="#d0d0d0">
                        <td class="text-center" colspan="2">
                            <button type="button" onclick="add_data_click()">Add New Data</button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>

    </div>
    <script language='javascript'>
    function add_data_click() {

        var newState = document.getElementById("newState").value;
        newState = newState.trim();
        var newPopulation = document.getElementById("newPopulation").value;
        newPopulation = newPopulation.trim();
        

        if (newState == '') {

            alert("Name is required!");
            document.getElementById("newState").focus();
            return;
        }
        if (newPopulation == ''|| isNaN(newPopulation)==true) {

            alert("Population Number is required! ; Enter an integer");
            document.getElementById("newPopulation").focus();
            return }
        if (newPopulation == '') {

            alert("Population Number is required!");
            document.getElementById("newPopulation").focus();
            return }

        show_loading();
        document.getElementById('myform').submit();

    }

    function show_loading(){

      document.getElementById("message").innerHTML=" <p style='text-align:center; color:green;'><b>Loading...</b></p> ";
    }
    </script>
</body>

</html>