<?php
session_start();

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
    <link rel="stylesheet" href="style.css">
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
            <nav class="nav flex-column px-1">
                <a class="nav-link form-control input-group-text my-2" href="About.php">About</a>
                <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a>
                <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a>
                <a class="nav-link form-control input-group-text my-2" href="IssueBook.php">Issue Book</a>
                <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a>
                <a class="nav-link form-control input-group-text my-2" href="SearchBook.php">Search Book</a>
                <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Issue/Return Book Report</a>
                <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
            </nav>
        </div>
        <div style="width: 80%; float: right;" class="form-control">
        <form action="" method="post">
        <div class="input-group mx-auto" style="width : 50%; height: 55px">
          <input type="text" class="form-control" placeholder="Enter the Book Id, Roll number, Book Title or Author" name="search" style="border-radius :10px 0px 0px 10px;">
          <button class="btn btn-primary btn-lg" type="submit" name="submit" value ="search" style="border-radius :0px 10px 10px 0px;">
          <img class="btn btn-primary btn-sm" src="./images/search.png" style="border-radius :0px 10px 10px 0px; max-width:44px;">
            <!-- <strong>Search</strong>  -->
          </button>
        </div>
        <br>
        </form>
        </div>
        <?php
        include 'databaseConnect.php';
        // if(isset($_POST['reset'])){
        //   echo '';
        // }
        if(isset($_POST['search']) && isset($_POST['submit'])){
          $id = $_POST['search'];
          $sql = "SELECT RollNo FROM issuebook WHERE  RollNo = '$id'";
          $sqlres = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($sqlres);
          if($num>0){
            $fine = 0;
            $sql = "SELECT Fine FROM addstudent where rollNumber = '$id'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
              $fine = $row['Fine'];
              // if($fine='' || $fine = null){
              //   $fine = '0';
              // }
            }
            ?>
            <br><br>
            <div class="d-inline p-2 bg-secondary border border-danger rounded text-white" style = "float:right;">Fine you need to pay : 
            
            <?php echo $fine;  ?> rupees</div>
            
            <?php } 
          $sql = "SELECT * FROM issuebook where BookId = '$id' OR RollNo = '$id' OR Title ='$id' OR Author ='$id'";
          $result = mysqli_query($conn, $sql);
          $num1 = mysqli_num_rows($result);
          $sql = "SELECT ReturnDate FROM issuebook where ReturnDate=''";
          $result1 = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($result1);
          if($num1==0){
            echo'<p class="text-danger"> &nbsp;&nbsp;No Records found in Issued List for '.$id.'.</p>';
          }
          $b =1;
          $a=1;
          // while($row = mysqli_fetch_array($result)){
            while($row = mysqli_fetch_array($result)){
              $roll = $row['RollNo'];
              $sql = "SELECT `firstName`, `lastName`, `Fine` FROM `addStudent` WHERE rollNumber = '$roll'";
              $stdn = mysqli_query($conn, $sql);
              while($column = mysqli_fetch_array($stdn)){
                $fullname = $column['firstName'] .' '. $column['lastName'];
                $fine = $column['Fine'];
              }    
        while($b!=0){
          
              ?>
              <div class="my-1" style="clear: left;">
                <div class="mx-1 " style ="width:auto; text-align:center; display:inline-block;"><b>&nbsp;Roll Number &nbsp;</b></div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"><b> Book Id</b></div> 
                <div class="mx-1" style ="width:10%; text-align:center; display:inline-block;"><b>Borrower Name</b></div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp;<b>Year</b></div> 
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp;&nbsp;<b>Issued on</b> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"> &nbsp;<b>Returned on</b> </div>
                <!-- <div class="mx-1" style ="width:20%; text-align:center; display:inline-block;"><b>Book Author</b></div> -->
                <div class="mx-1" style ="width:14%; text-align:center; display:inline-block;"><b>Book Title</b> </div>
                <div class="mx-1" style ="width:20%; text-align:center; display:inline-block;"><b> Branch</b></div> 
                </div><hr><br>
              <?php $b--; } 
              ?>
          <?php 
            if($row['ReturnDate']==''){
               ?>
              <div class="my-1">
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"><?php echo $row['RollNo'] ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp; <?php echo $row['BookId'] ?> </div> 
                <div class="mx-1" style ="width:10%; text-align:center; display:inline-block;">&nbsp; <?php echo $fullname ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp; <?php echo '2022' ?> </div> 
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"> <?php echo $row['IssueDate'] ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"><p class="text-success"><strong> &nbsp;&nbsp;&nbsp;issued &nbsp;&nbsp;</strong></p></div>
                <!-- <div class="mx-1" style ="width:12%; text-align:center; display:inline-block;"> <?php echo $row['Author'] ?> </div> -->
                <div class="mx-1" style ="width:14%; text-align:center; display:inline-block;">&nbsp; <?php echo $row['Title'] ?> </div>
                <div class="mx-1" style ="width:20%; text-align:center; display:inline-block;"> <?php echo $row['Branch'] ?> </div> 
                </div><hr>
                <!-- <div class="input-group-text" id="basic-addon1">
              <span style ="width :40%; background-color: white; border-radius : 5px; float:left;">
                <br>Borrower Roll Number<hr><br>Book Id<hr><br>Borrower Name<hr><br>Branch<hr><br>Year<hr><br>Issued on<hr>
                <br>Returned on<hr><br>Book Title<hr><br>Book Author<hr>
              </span>
              <span class="ms-1" style ="width :60%; background-color: white; border-radius : 5px; float:left;">
                <br><?php echo $row['RollNo'] ?><hr><br><?php echo $row['BookId'] ?><hr><br><?php echo $row['Branch'] ?><hr><br>
              <?php echo $row['Branch'] ?><hr><br><?php echo $row['Branch'] ?><hr><br><?php echo $row['IssueDate'] ?><hr>
              <br><p class="text-success"><strong>issued</strong></p><hr><br><?php echo $row['Title'] ?><hr><br><?php echo $row['Author'] ?><hr>
              </span> -->
        <!-- </div> -->
        <?php
              // $num--;
            // $num1--;
              }
          }
          $sql = "SELECT * FROM issuebook where BookId = '$id' OR RollNo = '$id' OR Title ='$id' OR Author ='$id'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_array($result)){
                if($row['ReturnDate']!=''){
                ?>
                <div class="my-1">
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"><?php echo $row['RollNo'] ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp; <?php echo $row['BookId'] ?> </div> 
                <div class="mx-1" style ="width:10%; text-align:center; display:inline-block;">&nbsp; <?php echo $fullname ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;">&nbsp; <?php echo '2022' ?> </div> 
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"> <?php echo $row['IssueDate'] ?> </div>
                <div class="mx-1" style ="width:auto; text-align:center; display:inline-block;"> <?php echo $row['ReturnDate'] ?></div>
                <!-- <div class="mx-1" style ="width:12%; text-align:center; display:inline-block;"> <?php echo $row['Author'] ?> </div> -->
                <div class="mx-1" style ="width:14%; text-align:center; display:inline-block;">&nbsp; <?php echo $row['Title'] ?> </div>
                <div class="mx-1" style ="width:20%; text-align:center; display:inline-block;"> <?php echo $row['Branch'] ?> </div> 
                </div><hr><br>
                <?php
                }                
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