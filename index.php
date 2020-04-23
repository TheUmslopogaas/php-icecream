<!-- Database codes and Showing the icecreams in the main page-->
<?php 
  // locating the database with which ill work 
  //checking whether the db connection has an error or not
  require('db_connect.php');
  //selecting what data to fetch. aka writing query
  $sql = 'SELECT title, materials, id FROM icecreams ORDER BY created_at';
  //making connection between the selected db and queried data
  $result = mysqli_query($connToDb, $sql);
  //fetch the datas as an array
  $icecreams = mysqli_fetch_all($result, MYSQLI_ASSOC);
  //free result from memory 
  mysqli_free_result($result);
  //close connection
  mysqli_close($connToDb);
  //printing the result as an array
  // print_r($icecreams)
 ?>

<!-- PHP main codes -->
<?php 
  //at first there should be no errors, thats why made empty errors array. will insert values whenever errors are found
  $errors = [
    'email' => '',
    'title' => '',
    'materials' => '',
  ];
  /* making the variables empty so the input field doesn't 
  echo undefined error in the input field (as i echoed them in the html input field) when i first load the page*/
  $email = $title = $materials = '';

  if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $title = htmlspecialchars($_POST['title']);
    $materials = htmlspecialchars($_POST['materials']);

   // Email check for unallowed input
    if (empty($email)) {
      $errors['email'] = 'An email is required . <br>';
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid Email . <br>';
      }
    }
   // Title check for unallowed input
    if (empty($title)) {
      $errors['title'] = 'A title is required . <br>';
    } else {
      if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
        $errors['title'] = 'Title should only be letters . <br>';
      }
   }
   // Materials check for unallowed input
    if (empty($materials)) {
      $errors['materials'] = 'At least one material is required . <br>';
    } else {
      if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $materials)) {
        $errors['materials'] = 'Materials must be a comma separated list . <br>';
      }
    }// checking ends

    /* If there is no error and the form is valid then going to clear 
    the input fields immediately after the form has been submitted */
    /*And also sending data to the database to create a new record*/
    if (!array_filter($errors)) {
      require('db_connect.php');
      //sending data to the db. and overwriting the variables to do so
      $email = mysqli_real_escape_string($connToDb, $_POST['email']);
      $title = mysqli_real_escape_string($connToDb, $_POST['title']);
      $materials = mysqli_real_escape_string($connToDb, $_POST['materials']);

      //selecting what data to send to the table. aka writing query
      $sql = "INSERT INTO icecreams(email, title, materials) VALUES('$email', '$title', '$materials')";
      // if query was successfull then sending back to the homepage, else echoeing the error
      if (mysqli_query($connToDb, $sql)) {;
        header('Location: index.php');
      } else {
        echo "Data send failed! Query error: " . mysqli_error($connToDb);
      }
    } //End of array filter for Errors
  } //Submitting the values from the form in the database ends
?>

<?php 
require('htmlpart.php');
?>