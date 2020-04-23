<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Icy Cream</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">  
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark justify-content-between">
    <a class="navbar-brand" href="#">ICY CREAM</a>
    <form class="form-inline my-2 my-lg-0">
      <button class="btn my-2 my-sm-0" type="submit">Add an Icecream</button>
    </form>    
  </nav>

  <!-- Body -->
  <div class="container">
    <h1 class="text-center display-4 font-weight-bold m-4">Add an Ice-cream</h1>
    <!-- forms -->

    <form class="form-parent" action="index.php" method="POST">
      <div class="form-group">
        <label for="email">Your Email:</label>
        <input name="email" type="text" class="form-control shadow-none" id="email" aria-describedby="emailHelp" value="<?php echo htmlspecialchars($email) ?>">
        <small id="emailHelp" class="form-text text-warning"><?php echo $errors['email']?></small>
      </div>
      <div class="form-group">
        <label for="iceName">Icecream Name:</label>
        <input type="text" name="title" class="form-control shadow-none" id="iceName" rows="1" value="<?php echo htmlspecialchars($title) ?>">
        <small id="emailHelp" class="form-text text-warning"><?php echo $errors['title']?></small>
      </div>
      <div class="form-group">
        <label for="materials">Materials (comma separated):</label>
        <input type="text" name="materials" class="form-control shadow-none" id="materials" rows="2" value="<?php echo htmlspecialchars($materials) ?>">
        <small id="emailHelp" class="form-text text-warning"><?php echo $errors['materials']?></small>
      </div>
      <button type="submit" class="btn m-auto d-block" name="submit">Submit</button>
    </form>

    <!-- Icecreams -->

    <div class="cards-parent row">
      <!-- I got an associ Array named $icecreams which has 2 more associ arrays in it. -->
      <?php foreach($icecreams as $ice){ ?>
        <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch mb-3">
          <div class="card">
            <div class="card-body text-center">
              <h5 class="card-title text-center">
                <!-- $ice represents a single record of icecream -->
                <?php echo $ice['title']; ?>
              </h5>
              <p class="card-text">
                <?php echo $ice['materials']; ?>                
              </p>
              <a href="details.php?id=<?php echo $ice['id']?>" class="btn btn-primary">More Info</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div> <!--Container Ends-->
    <footer>
      <p> Copyright &copy 2020 Icy Cream. </p>
    </footer>
      <script src="js/jquery.js"></script>
      <script src="js/popper.js"></script>
      <script src="js/bootstrap.min.js"></script>  
</body>
</html>
