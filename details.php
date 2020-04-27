<?php 
  require('db_connect.php');

  // This is to make the delete button work 
  if (isset($_POST['delete'])) {

    //This just returns an integer (the id of the particular product)
    /*$delete = $_GET['id_hidden'];  =>  emne dilew hoito
    Just special charecter escape korar jonno nicher moto kore disi*/
    $idHidden = mysqli_real_escape_string($connToDb, $_POST['id_hidden']);

    $sql = "DELETE FROM icecreams WHERE id = $idHidden";

    //making connection between the selected db and queried data
    $result = mysqli_query($connToDb, $sql);

    if (mysqli_query($connToDb, $sql)) {
      header('Location: index.php');
    } else {
      echo 'Query error: ' . mysqli_error();
    }

  }

  //This is to select data that are shown in the details page
  if (isset($_GET['id'])) {

    /*$id = $_GET['id'];  =>  emne dilew hoito
    Just special charecter escape korar jonno nicher moto kore disi*/
    $id = mysqli_real_escape_string($connToDb, $_GET['id']);

    //selecting what data to fetch. aka writing query
    $sql = "SELECT * FROM icecreams WHERE id = $id";

    //making connection between the selected db and queried data
    $result = mysqli_query($connToDb, $sql);

    //fetch the datas as an array. 
    $icecream = mysqli_fetch_assoc($result);

    //free result from memory 
    mysqli_free_result($result);

    //close connection
    mysqli_close($connToDb);

  } 

$materials = '';
$materialsError = ''; //as its just only one info (only materials, not email and/or title) thats why declared a var instead of arr

  if (isset($_POST['edit'])) {

    $materials = htmlspecialchars($_POST['editmats']);

    // Materials check for unallowed input
    if (empty($materials)) {
      $materialsError = 'At least one material is required . <br>';
    } else {
      if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $materials)) {
        $materialsError = 'Materials must be a comma separated list . <br>'; 
      }
    }

    // If no error in the input has been found, then this code below will run 
    // this will update/edit the database and take the page back to main
    if ($materialsError == '') {
      require('db_connect.php');

      $idHidden = mysqli_real_escape_string($connToDb, $_POST['id_hidden']);

      $edit = mysqli_real_escape_string($connToDb, $_POST['editmats']);

      //the $edit variable must be in '', cz otherwise the materials wouldn't be a string. And in the db material is string/varchar
      $sql = "UPDATE icecreams SET materials = '$edit' WHERE id = $idHidden ";

      $result = mysqli_query($connToDb, $sql);

      if (mysqli_query($connToDb, $sql)) {
        header('Location: index.php');
      } else {
        echo 'Query error: ' . mysqli_error();
      } 
    } // Updated the db if no errors exist

  } //End of updating the db

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Icy Cream</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">  
  <style>
    .details-form {
      border: none;
      padding: 0px 40px 20px 40px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark justify-content-between">
    <a class="navbar-brand" href="#">ICY CREAM</a>
    <form class="form-inline my-2 my-lg-0">
      <a href="index.php" class="btn my-2 my-sm-0" type="submit">Add an Icecream</a>
    </form>    
  </nav>

  <div class="container">
    <?php if ($icecream): ?> <!--we got a record of one icecream back as an array-->
    <div class="display-4 text-center mt-5">Ice Cream details are listed below</div>
      <div class="card mt-5" style="width: 50%; margin: 0 auto">
        <div class="card-body text-center">
          <h3 class="card-text">Icecream name: </h3>
          <h5 class="card-text pb-3"><?php echo $icecream['title'] ?></h5>
          <h5 class="card-text">Materials are: </h5>
          <p class="card-text"><?php echo $icecream['materials'] ?></p>
          <h5 class="card-text">Created at:</h5>
          <p class="card-text"><?php echo date($icecream['created_at']) ?></p>
        </div>

        <!-- id containing button and delete button -->
        <form class="form-parent details-form" action="details.php?id=<?php echo $_GET['id']?>" method="POST"> <!-- if the edit fails, then wanna load to the exact page associated with the id. thats why id was passed on the action-->
          <input type="hidden" class="btn m-auto d-block" name="id_hidden" value="<?php echo $_GET['id']?> ">
          <input type="submit" class="btn m-auto d-block" name="delete" value="DELETE">
        </form>
      </div>

      <!-- Edit form -->
      <form class="form-parent mt-5 mb-5" action="details.php?id=<?php echo $_GET['id']?>" method="POST"> <!-- if the dit fails, then wanna load to the exact page associated with the id. thats why id was passed on the action-->
        <input type="hidden" class="btn m-auto d-block" name="id_hidden" value="<?php echo $_GET['id']?> ">
        <div class="form-group">
          <label for="editmats">Edit the Materials (comma separated):</label>
          <input type="text" name="editmats" class="form-control shadow-none" id="editmats" rows="2" value="<?php echo $materials?>">
          <small id="emailHelp" class="form-text text-warning"><?php echo $materialsError?></small>
        </div>
        <input type="submit" class="btn m-auto d-block" name="edit" value="EDIT">    

      </form>

    <?php else: ?> <!--If a id has been passed which doesnt exist, then this'll run-->
      <div class="display-4 text-center">No such icecream exists!</div>
    <?php endif; ?>  


  </div><!--  Container Ends -->
  <footer>
    <p> Copyright &copy 2020 Icy Cream. </p>
  </footer>

      <script src="js/jquery.js"></script>
      <script src="js/popper.js"></script>
      <script src="js/bootstrap.min.js"></script>  
</body>
</html>
