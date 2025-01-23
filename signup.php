<?php

session_start();
require_once("db.php");

function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$errors = array();
$email = "";
$username = "";
$password = "";
$cpassword = "";
$dob = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = sanitize_input($_POST["email"]);
  $username = sanitize_input($_POST["username"]);
  $password = sanitize_input($_POST["password"]);
  $cpassword = sanitize_input($_POST["cpassword"]);
  $dob = sanitize_input($_POST["dob"]);

  $emailRegEx = '/\S+@\S+\.\S+/';
  $pwdRegEx = '/^[^\s]{8,}$/';
  $dobRegEx = '/^\d{4}[-]\d{2}[-]\d{2}$/';
  $avatarRegEx = '/^[^\n]+.[a-zA-Z]{3,4}$/';
  $unameRegEx = '/^\w+$/';
  
  if (empty($email) || !preg_match($emailRegEx, $email)) {
    $errors[] = "Email is invalid";
  }

  if (empty($username) || !preg_match($unameRegEx, $username)) {
    $errors[] = "Username is invalid";
  }

  if (empty($password) || !preg_match($pwdRegEx, $password)) {
    $errors[] = "Password is invalid";
  }

  if (empty($cpassword) || $cpassword !== $password) {
    $errors[] = "Passwords do not match";
  }

  if (empty($dob) || !preg_match($dobRegEx, $dob)) {
    $errors[] = "Date of birth is invalid";
  }

  if (empty($errors)) {
    try {
      $pdo = new PDO($attr, $db_user, $db_pwd, $options);

      $stmt = $pdo->prepare("INSERT INTO User (email, username, password, dob) VALUES (?, ?, ?, ?)");
      $stmt->execute([$email, $username, $password, $dob]);

      $targetDir = "uploads/";
      $profilePhoto = $targetDir . basename($_FILES["avatarUrl"]["name"]);
      
      if (move_uploaded_file($_FILES["avatarUrl"]["tmp_name"], $profilePhoto)) {
        $photoUrl = $targetDir . $_FILES["avatarUrl"]["name"];
        //is it User?
        $stmt = $pdo->prepare("UPDATE User SET avatarUrl = ? WHERE email = ?");
        $stmt->execute([$photoUrl, $email]);

        header("Location: main.php");
        exit();
      } 
      else {
        $errors[] = "Error uploading profile photo";
      }
    } 
    catch (PDOException $e) {
      $errors[] = "Database error: " . $e->getMessage();
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
          <li class="navigation"><a href=""><img src="images/logo.png" alt="Image of logo" class="logo"/></a></li>
          <li class="navigation" id="heading">CS 215 - Group 28</li>
        </ul>
      </header>
    </div>
    <div class="box2"> <!-- Left-most box -->
      <!-- In the signup page, it remains empty -->
    </div>
    <div class="box3"> <!-- Center box - holds main content -->
      <h2>Sign up</h2>
      <form class="auth-form" action="main_al.php" method="post" id="signup-form">

        <div class="input-field">
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" />
          <p id="error-text-email" class="error-text hidden">Email is invalid</p> 
        </div>

        <div class="input-field">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" />
          <p id="error-text-username" class="error-text hidden">Username is invalid</p>
        </div>

        <div class="input-field">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password"/>
          <p id="error-text-password" class="error-text hidden">password is invalid</p>
        </div>

        <div class="input-field">
          <label for="cpassword">Confirm Password:</label>
          <input type="password" id="cpassword" name="cpassword" />
          <p id="error-text-cpassword" class="error-text hidden">Passwords does not match</p>
        </div>

        <div class="input-field">
          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" name="dob"  />
          <p id="error-text-dob" class="error-text hidden">Date of birth is invalid</p>
        </div>

        <div class="input-field">
          <label for="photo">Avatar:</label>
          <input type="file" id="profilephoto" name="profilephoto" />
          <p id="error-text-profilephoto" class="error-text hidden">No file selected</p>
        </div>

        <input type="submit" style="margin-bottom: 20px;" value="Sign up">
      </form>
      <p>Already have an account? <a href="main_bl.php">Login</a></p>
    </div>
    <div class="box4"> <!-- Right-most box -->
      <!-- In the signup page, it remains empty -->
    </div>
    <div class="box5"> <!-- Bottom box - footer box -->
      <p>Wooyoung (200468344) - Hunter (200471793) - Shahd (200490266)</p>
    </div>
  </div>
  <script src="js/eventRegisterSignup.js"></script>
</body>

</html>