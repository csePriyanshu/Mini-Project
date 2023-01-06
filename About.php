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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
        <img src="images/logo.png" style="margin-left: 45%; max-width: 20vw;">
      </div>
    </header>
    <br>
    <div class="columnLeft" style="width: 20%; padding: 0px; float: left;">
      <nav class="nav px-1 navBar">
        <a class="nav-link form-control input-group-text my-2" href="#" style="background-color: whitesmoke;">About</a>
        <a class="nav-link form-control input-group-text my-2" href="AddBook.php">Add Book</a>
        <a class="nav-link form-control input-group-text my-2" href="AddStudent.php">Add Student</a>
        <a class="nav-link form-control input-group-text my-2" href="IssueBook.php">Issue Book</a>
        <a class="nav-link form-control input-group-text my-2" href="ReturnBook.php">Return Book</a>
        <a class="nav-link form-control input-group-text my-2" href="SearchBook.php">Search Book</a>
        <a class="nav-link form-control input-group-text my-2" href="Report.php">Issue/Return Book Report</a>
        <a class="nav-link form-control input-group-text my-2" href="LogOut.php">Log Out</a>
        
      </nav>
    </div>
    <div style="width: 80%; text-align :center; float :right;" class="form-control mt-2">
    <span class="input-group-text" id="basic-addon1">
      <span style ="width :40%; background-color: white; border-radius : 5px; float:left;">
        <br>Name<hr><br>Branch<hr><br> Current Year of Graduation<hr><br>Roll Number<hr><br>Subject<hr><br>Team Name<hr>
        <br>Technology<hr><br>Programming Language used<hr><br>Language I Know<hr>
        <br>Framewoks used<hr>
        <!-- <br><br>Reference<br><br><br><hr><hr> -->
      </span>
      <span class="ms-1" style ="width :60%; background-color: white; border-radius : 5px; float:left;">
      <br><b>Priyanshu Shukla</b><hr><br>Computer Science Engineering<hr><br>3rd year (Sem-6)<hr><br>190013135064<hr><br>Mini Project (CS-653)<hr><br>Hello World (Single)<hr>
      <br><b>Full Stack Web Development</b><hr><br>HTML, CSS, PHP, MYSQL, Javascript<hr><br><b>Java, HTML, CSS, Javascript, PHP, MYSQL, C</b><hr>
      <br>Bootstrap, XAMPP Apache Server, myphpadmin<hr>
      <!-- <span style ="width :40%; background-color: white; border-radius : 5px; float:left;">
      For Use Case Diagram<hr>For E-R Diagram<hr>For php coding help<hr>
      </span> -->
      <!-- <span class="" style ="width :60%; background-color: white; border-radius : 5px; float:left;">
      https://meeraacademy.com<hr>https://ermodelexample.com<hr>https://www.php.net/manual<hr>
      </span> -->
      
      
      </span>
    </span>




      <!-- Name : &nbsp; -->
      <?php 
      // $name="prianshukla";
      //  if($_SESSION['username']==$name){
      //   $name = "<b>Priyanshu Shukla</b> (Admin)";
      //   echo $name;
      //   echo "<br><br>";
      //   echo "Branch : Computer Science Engineering
      //   <br><br>
      //   Year : III (Sem - 6)
      //   <br><br>
      //   Roll Number : <b>190013135064</b>
      //   <br><br>
      //   Subject : Mini-Project (CS-653)
      //   <br><br>
      //   Team Name : Hello World (Single)
      //   <br><br>
      //   Technology : Web Development using PHP and MYSQL
      //   <br><br>
      //   Topic : <b>Library Management System</b>
      //   <br><br>
      //   Language Used : HTML, CSS, PHP, MYSQL
      //   <br><br>
      //   Languages I Know : <b>Java, HTML, CSS, Javascript, PHP, MYSQL, C</b>
      //   <br><br>
      //   Frameworks used : Bootstrap, XAMPP Apache Server, myphpadmin
      //   <br><br>
      //   Reference : For Use Case Diagram --> https://meeraacademy.com/<br>
      //   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      //   For E-R Diagram --> https://ermodelexample.com/
      //   <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      //   For php coding help --> https://www.php.net/manual";
      // }else{
      //   $name = $_SESSION['username'];
      //   echo $name;
      //   echo $_SESSION['lastname'];
        // echo "<br>";
        // echo "Branch : "; echo $_SESSION['userinfo']['lastname'];
      // }
      ?>
    </div>
    <footer class="form-control input-group-text mt-5">
      &copy; Priyanshu Shukla
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
</body>

</html>