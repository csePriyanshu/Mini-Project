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
  
  // $a = 5;
  // echo $a-1;
  
  
  include 'databaseConnect.php';
          $title ="";
          $author = "";
          $rollno = "";
          $branch = "";
          $issue ="";
          $issuedate ="";
          // $fine =0;
          if(isset($_POST['submitsearch']) && isset($_POST['search'])){
            $id = $_POST['search'];
            $tit = "SELECT `Title` FROM `book` WHERE BookId = '$id'";
            $currenttit = mysqli_query($conn, $tit);
            while($row = mysqli_fetch_assoc($currenttit)){
            $title = $row['Title'];
            // echo $title;
            }
            $auth = "SELECT `Author` FROM `book` WHERE BookId = '$id'";
            $currentauth = mysqli_query($conn, $auth);
            while($row = mysqli_fetch_assoc($currentauth)){
            $author = $row['Author'];
            }
            $rollnu = "SELECT `RollNo` FROM `issuebook` WHERE BookId = '$id'";
            $currentroll = mysqli_query($conn, $rollnu);
            while($row = mysqli_fetch_assoc($currentroll)){
            $rollno = $row['RollNo'];
            }
            $branchc = "SELECT `Branch` FROM `issuebook` WHERE BookId = '$id'";
            $currentbranch = mysqli_query($conn, $branchc);
            while($row = mysqli_fetch_assoc($currentbranch)){
            $branch = $row['Branch'];
            }
            $issuec = "SELECT `IssueDate` FROM `issuebook` WHERE BookId = '$id'";
            $currentissue = mysqli_query($conn, $issuec);
            while($row = mysqli_fetch_assoc($currentissue)){
            $issue = $row['IssueDate'];
            

            //finding current date

            $mydate=getdate(date("U"));
            $getdate = "$mydate[month] $mydate[mday], $mydate[year]";
            $date=date_create($getdate);
            // echo $date;
            // date_add($date,date_interval_create_from_date_string("1 days"));
            $issuedate = date_format($date,"d-m-Y");
            $issuedte = strtotime($issue);
            // echo $issuedte,'<br>';
            // echo $issue.'<br>';


  
            //calculation of fine


            $dte = date('y-m-d', $issuedte);
             // echo $dte .'<br>';
             // $issuedte1 = strtotime($issuedate);
             // echo $issuedte1,'<br>';
             // echo $issuedate.'<br>';
             // $dte1 = date('d-m-y', $issuedte1);
             // echo $dte1.'<br>';
                     $date = new DateTime($dte);
             $now = new DateTime();
             // echo $date ->format('d <br>');
             // echo $now ->format('d <br>');
             // echo $date("y-m-d");
             // $now = date("y-m-d");
             // echo $now;
             $diffdays = date_diff($date, $now) ->format("%d");
             $diffmonths = date_diff($date, $now) ->format("%m");
             // echo $diffdays.'<br>'.$diffmonths .'<br>';
             $fine = ($diffmonths *30) + ($diffdays -14);
             if($fine<0){
               $fine =0;
             }
             // echo $fine;
                     }
          }
          
  
  $showAlert = false;




    



  if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['summit'])){
     

    //finding current date

    $mydate=getdate(date("U"));
    $getdate = "$mydate[month] $mydate[mday], $mydate[year]";
    $date=date_create($getdate);
    // echo $date;
    // date_add($date,date_interval_create_from_date_string("1 days"));
    $issuedate = date_format($date,"d-m-Y");

    $id = $_POST['id'];
    $checkId = "SELECT `BookId` FROM `issuebook` WHERE BookId = '$id'";
    $resultid = mysqli_query($conn, $checkId);
    $countid = mysqli_num_rows($resultid);
    $checkRoll = "SELECT `RollNo` FROM `issuebook` WHERE BookId = '$id'";
    $resultRoll = mysqli_query($conn, $checkRoll);
    $rollnow ='1';
    while($row = mysqli_fetch_assoc($resultRoll)){
      $rollnow = $row['RollNo'];
    }
    $countroll = mysqli_num_rows($resultRoll);
    // echo $countroll.'<br>';
    // echo $countid;
    // echo $id;
   
    // echo $author;
    $fineto = $_POST['fine'];
    if(isset($_POST['finepaid'])){
      $fineto = 0;
    }
    $sql = "UPDATE `addstudent` SET Fine = CASE WHEN Fine IS NULL OR Fine = '' THEN '$fineto' ELSE Fine + '$fineto' END WHERE rollNumber = '$rollnow'";
      $result = mysqli_query($conn, $sql);
      if(!$result){
        echo "Error! The Book cannot be returned for now due to -->" .mysqli_error($conn);
      } else{
        $showAlert = true;
        $availability = null;
        $available = "SELECT `QuantityAvailable` FROM `book` WHERE BookId = '$id'";
            $current = mysqli_query($conn, $available);
            while($row = mysqli_fetch_assoc($current)){
            $availability = $row['QuantityAvailable'];
            }
        $current = $availability+1;
        $title = $_POST['title'];
        $update = "UPDATE `book` SET `QuantityAvailable` = '$current' WHERE `Title` = '$title'";
        mysqli_query($conn, $update);
        // $sql = "INSERT INTO returnedbook SELECT * FROM issuebook";
        // mysqli_query($conn, $sql);
        // $update = "UPDATE `issuebook` SET `IssueDate` = ' ', `ReturnDate` = ' ' WHERE `BookId` = '$id'";
        // mysqli_query($conn, $update);
      }
    // if($countroll>0 && $countid>0){
      // echo $issuedate;
      
    // }else if($countid==0 && $countroll==0){
    //   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //         <strong>Error!</strong> Enter a valid Roll Number and Book Id , please try again.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //       </div>';
    // } else if($countid==0){
    //   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //         <strong>Error!</strong> Enter a valid Book Id , please try again.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //       </div>';
    // } else if($countroll==0){
    //   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //         <strong>Error!</strong> Enter a valid Roll Number , please try again.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //       </div>';
    // }
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
      <?php 

  if($showAlert && $_POST['roll']!="" && isset($_POST['summit'])){
    // echo $current;
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> The Book is added back to the shelf.<br>
          Number of Books Available is '.$current.'
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        // exit;
        // header("Location: ReturnBook.php");

    } else if(!isset($_POST['search']) && isset($_POST['summit'])){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Failed to return!</strong> Please enter valid details.<br>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
?>
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
                <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">Return Book</a>
                <a class="nav-link form-control input-group-text my-2" href="SearchBook.php">Search Book</a>
                <a class="nav-link form-control input-group-text my-2" href="Report.php">Issue/Return Book Report</a>
                <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
            </nav>
        </div>
        <div style="width: 80%; float: right;" class="form-control">
        <form action="" method="post">
        <div class="input-group" style="width : 15vw; float:right;">
          <input type="text" class="form-control" placeholder="Enter the book id" name="search" style="border-radius :10px 0px 0px 10px;">
          <button class="btn btn-primary btn-sm" type="submit" value ="search" name="submitsearch" style="border-radius :0px 10px 10px 0px;"><img class="btn btn-primary btn-sm" src="./images/search.png" style="border-radius :0px 10px 10px 0px; max-width:44px;"></button>
        </div>
        <br>
        </form>
        
        <br>
        <form action="" method="post">
        <div class="input-group">
          <span class="input-group-text">Book Id</span>
          <input type="text" class="form-control" placeholder="Enter Book Id" name="id" id="Bookid" value="">
          <script>
            document.getElementById("Bookid").value = "<?php echo $id ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Book Title</span>
          <input type="text" class="form-control" placeholder="Enter Title of the book" name="title" id="title" value="">
          <script>
            document.getElementById("title").value = "<?php echo $title ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Roll Number</span>
          <input type="text" class="form-control" placeholder="Enter borrower roll number" name="roll" id="roll" value="">
          <script>
            document.getElementById("roll").value = "<?php echo $rollno ?>";
          </script>
        </div>
        <br>
        <div class="input-group">
          <span class="input-group-text">Branch</span>
          <span class="form-control"><?php echo $branch ?></span>
        </div>
        <br>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Return Date</span>
          <input type="text" class="form-control" placeholder="Date to return" name="issue" id="issue" value="">
          <script>
            document.getElementById("issue").value = "<?php echo $issuedate ?>";
          </script>
        </div>
        <br><div class="input-group">
          <span class="input-group-text">Author</span>
          <span class="form-control"><?php echo $author ?></span>
        </div>
        <br>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Fine</span>
          <input type="text" class="form-control " placeholder="in rupees" name="fine" id="fine" value="">
          <!-- <span class="ms-5 input-group-text" id="basic-addon1">Fine Paid</span>
          <input type="checkbox" class="me-5 my-auto ms-1 form-check-input" placeholder="in rupees" name="finecheck" id="finecheck" value=""> -->
          <!-- <input class="form-check-input input-group-text" type="checkbox" value="" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Fine Paid
          </label> -->
          <script>
            document.getElementById("fine").value = "<?php echo $fine; ?>";
          </script>
          <span class="input-group-text">issued on</span>
          <span class="form-control"><?php echo $issue ?></span>
        </div>
        <div class="form-check form-switch ms-3">
          <input class="form-check-input" type="checkbox" role="switch" id="finepaid" name="finepaid">
          <label class="form-check-label ms-1" for="flexSwitchCheckDefault">The Fine is Paid</label>
          <!-- <script> 
            if(document.getElementById("finepaid").checked){
              return 0;
            }else{
              return;
            }
          </script> -->
        </div>
        <br>
        
        
        
        
        <div class="d-grid gap-2 col-6 mx-auto" style="display : inline-block;">
          <input class="btn btn-primary btn-sm" type="submit" name="summit"></input>
          <input class="btn btn-secondary btn-sm" type="Reset" name="reset"></input>
          <?php  
            if(isset($_POST['reset'])){
              header (Location : "ReturnBook.php");
            }
          ?>
        </div>
      </form>
        </div>
        <footer class="form-control input-group-text mt-5">
            &copy; Priyanshu Shukla
          </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>
<?php $_POST = array(); ?>