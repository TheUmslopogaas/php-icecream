<?php 
  // locating the database with which ill work
  $connToDb = mysqli_connect('localhost', 'kazal', 'test1234', 'icy_cream');

  //checking whether the db connection has an error or not
  if(!$connToDb){
    echo 'Connection Error: ' . mysqli_connect_error();
  }
 ?>