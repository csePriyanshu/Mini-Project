<?php
session_start();
include 'databaseConnect.php';
if(!isset($_SESSION['username'])){
  ?>

 <script>
   alert("Do log in first");
    location.replace("index.html");
  </script>

<?php
  exit();
}

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library</title>
    <link rel="stylesheet" href="style.css" style="float: right;">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
    <div class="shadow p-3 mb-5 bg-body rounded container">
        <!-- <header class="p-3 mb-2 input-group-text rounded">
            <img src="images/logo.png"> 
            <img src="images/logo-2.png">
            <br><h1>Library Management System</h1>
        </header> -->
        <header>
            <div class="input-group-text">
                <h1 style="font-size: 2vw;">Library Management System</h1>
                <img src="images/logo.png" style="margin-left: 45%; max-width: 20vw;" >
            </div>
        </header>
        <br>
        <div class="columnLeft" style="width: 20%; padding: 0px; float: left;">
        <?php 
          $username = $_SESSION['username'];
          $query = "SELECT `imgname` FROM `addstudent` WHERE `usernameStd` = '$username'";
          $result = mysqli_query($conn, $query);
          
          while($row = mysqli_fetch_assoc($result)){
            $image = $row['imgname'];
          }
            echo '<img class="nav-link input-group-text mx-auto my-2" style="background-color: whitesmoke;
             max-width : 100vw; height : 189px"
            src="./profile/'.$image.'">';
          // echo $image;
          // echo $username;
          // echo '<br> jpg.jpg';
          // $folder = "./profile/".$image;
          // echo $folder = "./profile/".$image;
          
        ?>
            <nav class="nav flex-column px-1">
                <a class="nav-link form-control input-group-text my-2" href="StudentLanding.php">About</a>
                <!-- <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a>
                <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a>
                <a class="nav-link form-control input-group-text my-2" href="IssueBook.php">Issue Book</a>
                <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a> -->
                <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Search Book</a>
                <a class="nav-link form-control input-group-text my-2" href="ReportStd.php">Issue/Return Book Report</a>
                <a class="nav-link form-control input-group-text my-2" href="LogOutStd.php">Log Out</a>
            </nav>
        </div>
        <div style="width: 80%; float: right;" class="form-control">
        <form method="post">
          <div class="input-group">
            <span class="input-group-text">Book Id</span>
            <input type="text" class="form-control" placeholder="Search Book By id, title or author" name="id">
          </div>
          <?php
              // if($_POST['id']=="" && isset($_POST['submit'])){
              //   echo '<p class="text-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              //   &nbsp;&nbsp; !id can not be empty<br></p>';
              // }  
            ?>
          <br>
          <div class="d-grid gap-2 col-6 mx-auto" style="display : inline-block; width: 20vw">
            <input class="btn btn-primary btn-sm" type="submit" value="Search" name = "submit"></input>
            <input class="btn btn-secondary btn-sm" type="submit" value="Reset" name = "reset"></input>
          </div>
          <br>
          </form>
        </div>
        <?php
        include 'databaseConnect.php';
        if(isset($_POST['reset'])){
          echo '';
        }
        // if($_POST['id']=="" && isset($_POST['submit'])){
        //   echo '!Field can not be empty';
        // }
        if(isset($_POST['submit']) && $_POST['id']!=""){
          $id = $_POST['id'];
          $sql = "SELECT * FROM book where BookId = '$id' OR Title ='$id' OR Author ='$id'";
          $result = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($result);
          if($num==0){
            echo'<p class="text-danger"> &nbsp;&nbsp;No book exist, please enter valid Book details!</p>';
          }
          while($row = mysqli_fetch_array($result)){

            ?>
            <span class="input-group-text" id="basic-addon1">
              <span style ="width :40%; background-color: white; border-radius : 5px; float:left;">
                <br>Book Id<hr><br>Title<hr><br>Branch<hr><br>Year<hr><br>Bought on<hr><br>Author<hr>
                <br>Price<hr><br>Available Quantity<hr>
              </span>
              <span class="ms-1" style ="width :60%; background-color: white; border-radius : 5px; float:left;">
                <br><?php echo $row['BookId'] ?><hr><br><?php echo $row['Title'] ?><hr><br><?php echo $row['Branch'] ?><hr><br>
              <?php echo $row['Year'] ?><hr><br><?php echo $row['BoughtOn'] ?><hr><br><?php echo $row['Author'] ?><hr>
              <br><?php echo $row['Price'] ?><hr><br><?php echo $row['QuantityAvailable'] ?><hr>
              </span>
            </span>


            <!-- <form method="post">
              <div style="width: 80%; float: right;" class="form-control">
                <br>
                <div class="input-group">
                  <span class="input-group-text">Book Id</span>
                  <input type="text" class="form-control" name="id" value="<?php echo $row['BookId']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Title</span>
                  <input type="text" class="form-control" name="title" value="<?php echo $row['Title']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Branch</span>
                  <input type="text" class="form-control" name="branch" value="<?php echo $row['Branch']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Year</span>
                  <input type="text" class="form-control" name="year" value="<?php echo $row['Year']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Bought on</span>
                  <input type="date" class="form-control" name="boughton" value="<?php echo $row['BoughtOn']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Author</span>
                  <input type="text" class="form-control" name="author" value="<?php echo $row['Author']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Price</span>
                  <input type="text" class="form-control" name="price" value="<?php echo $row['Price']; ?>">
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-text">Quantity Available</span>
                  <input type="text" class="form-control" name="quantity" value="<?php echo $row['QuantityAvailable']; ?>">
                </div>
              </div>
            </form> -->

            <?php
          }
        }

        ?>
        <footer class="form-control input-group-text mt-5">
            &copy; Priyanshu Shukla
          </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>