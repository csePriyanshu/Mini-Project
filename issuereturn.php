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
        $availability = null ;
        $title ="";
        $author = "";
        $id="";
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])){
          $id = $_POST['search'];
          $available = "SELECT `QuantityAvailable` FROM `book` WHERE BookId = '$id'";
          $current = mysqli_query($conn, $available);
          while($row = mysqli_fetch_assoc($current)){
          $availability = $row['QuantityAvailable'];
          }
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
        }
        

$showAlert = false;
$mydate=getdate(date("U"));
  $getdate = "$mydate[month] $mydate[mday], $mydate[year]";
  $date=date_create($getdate);
  // echo $date;
  date_add($date,date_interval_create_from_date_string("1 days"));
  $issuedate = date_format($date,"d-m-Y");
  date_add($date,date_interval_create_from_date_string("14 days"));
  $expected = date_format($date,"d-m-Y");
  // echo $issuedate;
  // echo $expected;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['roll'])){
  $id = $_POST['id'];
  $title = $_POST['title'];
  $branch = $_POST['branch'];
  $roll = $_POST['roll'];
//   $returndate = $_POST['return'];
  
  // echo $issuedate;
  // $author = $_POST['author'];
  $availability = $_POST['available'];
  $checkId = "SELECT `BookId` FROM `book` WHERE BookId = '$id'";
  $resultid = mysqli_query($conn, $checkId);
  $countid = mysqli_num_rows($resultid);
  $checkRoll = "SELECT `rollNumber` FROM `addstudent` WHERE rollNumber = '$roll'";
  $resultRoll = mysqli_query($conn, $checkRoll);
  $countroll = mysqli_num_rows($resultRoll);
  // echo $countroll.'<br>';
  // echo $countid;
  // echo $id;
 
  // echo $author;
  if($countroll>0 && $countid>0){
    // echo $issuedate;
    $issuedate = $_POST['issue'];
    $sql = "INSERT INTO `issuebook`(`BookId`, `Title`, `Branch`, `RollNo`, `IssueDate`, `ReturnDate`, `Fine`, `Author`)
    VALUES ('$id', '$title', '$branch', '$roll', '$issuedate','','', '$author')";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      echo "Error! The Book cannot be added to the library list due to -->" .mysqli_error($conn);
    } else{
      $showAlert = true;
      $current = $availability-1;
      $update = "UPDATE `book` SET `QuantityAvailable` = '$current' WHERE `Title` = '$title' ";
      mysqli_query($conn, $update);
    }
  }else if($countid==0 && $countroll==0){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Enter a valid Roll Number and Book Id , please try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  } else if($countid==0){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Enter a valid Book Id , please try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  } else if($countroll==0){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Enter a valid Roll Number , please try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }
}
?>