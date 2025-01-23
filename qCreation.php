<?php
session_start();
require_once("db.php");

if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
} 
else {
    $errors = array();
    $userID = $_SESSION["userID"];
    $content = $_POST["content"];
    $timestamp = date("Y-m-d H:i:s");
  
    // Check if form submitted via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
        // Validate question content
        if (empty($content) || !validateQuestion($content)) {
            $errors[] = "Your Question is invalid";
        } 
        else {
          try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            
            // Prepare and execute SQL query to insert question into database
            $stmt = $db->prepare("INSERT INTO Question (userID, content, timestamp) VALUES (?, ?, ?)");
            $stmt->execute([$userID, $content, $timestamp]);
            
            // Redirect to Question Management Page after successful insert
            header("Location: qManagement.php");
            exit();

          } 
          catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
          }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>CS 215 Homepage</title>
  <script src="js/eventHandlers.js"></script>
</head>

<body>
  <div class="container">
    <div class="box1"> <!-- Top most box - box for header items -->
      <header>
        <ul class="navigation">
          <li class="navigation"><a href="main_al.php"><img src="images/logo.png" alt="Image of logo" class="logo"/></a></li>
          <li class="navigation" id="heading">Question Creation</li>
          <li class="navigation"><a href="qManagement.php"><img src="images/avatar.png" alt="Avatar" class="avatar"></a></li>
          <li class="navigation" style="float:right"><a class="screenName" href="qManagement.html">UserName</a></li>
        </ul>
      </header>
    </div>
    <div class="box2"> <!-- Left-most box -->
      <!-- In the signup page, it remains empty -->
    </div>
    <div class="box3"> <!-- Center box - holds main content -->
        <form class="qInputBox" action="qManagement.php" id="qCreation-form">
          <a href="questionMangement.php"> <img src="images/exitButton.jpg" class="exitButt"/> </a>
          <label for="Qcreation" style="margin-right:100%">Question:</label>
          <textarea type="text" id="Qcreation" onkeyup="count(this);" row="6" column="80" ></textarea>
          <div><p id="charNum" style="float: left;">1500 characters remaining</p></div>
          <p id="error-text-qCreation" class="error-text hidden">Cannot be left empty.</p>
          <input type="submit" style="float: right;" value="Post">
        </form>
    </div>
    
    <div class="box4"> <!-- Right-most box -->
      <!-- In the signup page, it remains empty -->
    </div>
    
    <div class="box5"> <!-- Bottom box - footer box -->
      <p>Wooyoung (200468344) - Hunter (200471793) - Shahd (200490266)</p>
    </div>
  </div>
  <script src="js/eventRegisterQcreation.js"></script>
</body>
</html>