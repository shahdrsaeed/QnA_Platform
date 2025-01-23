<?php

session_start();
require_once('db.php');

// Check if the user is already logged in
if(isset($_SESSION['userID'])) {
    // Redirect to main_al.php if the user is already logged in
    header("Location: main_al.php");
    exit;
}

//$questions = [];

try {
  $conn = new PDO($attr, $db_user, $db_pwd, $options);

  $query = "
   SELECT
   Q.questionID,
   Q.content AS questionContent,
   Q.timestamp AS questionTimestamp,
   COUNT(A.answerID) AS answerCount
   FROM Question AS Q
   LEFT JOIN Answer AS A ON Q.questionID = A.questionID
   GROUP BY Q.questionID, Q.content, Q.timestamp
   ORDER BY Q.timestamp DESC
   LIMIT 5
  ";

  $result = $conn->query($query);

} 
catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  die();
}

?>
  
<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>CS 215 Webpage</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <script src="js/eventHandlers.js"></script>
</head>

<body>
  <div class="container">
    <div class="box1">
      <header>
        <ul class="navigation">
          <li class="navigation"><a href="main.php"><img src="images/logo.png" alt="Image of logo" class="logo" /></a>
          </li>
          <li class="navigation" id="heading">CS 215 - Group 28 Main Page</li>
          <li class="navigation"></li>
          <li class="navigation" style="float:right"></li>
        </ul>
      </header>
    </div>
    <div class="box2">
      <!-- In the login page, it remains empty -->
    </div>
    <div class="box3"> <!-- Center box - holds main content -->
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
      <div class="questionBox">
        <p><?php echo htmlspecialchars($row['questionTimestamp']); ?></p>
        <p>Question: <?php echo htmlspecialchars($row['questionContent']); ?></p>
        <p>Answers: <?php echo $row['answerCount']; ?></p>
        <img src="images/thumbsUp.jpg" class="like" />
        <img src="images/thumbsDown.jpg" class="like" />
      </div>
    <?php endwhile; ?>
    </div>
    <div class="box4">
      <form class="auth-form" style="width: 70%;" action="main_al.php" method="post" id="login-form">
        <div class="input-field">
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" style="width: 100%" />
          <p id="error-text-email" class="error-text hidden">Email is invalid</p> 
        </div>
        <div class="input-field">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" style="width: 100%" >
          <p id="error-text-password" class="error-text hidden">password must be 6 characters or longer, no spaces</p>
        </div>
  
        <div class="input-field">
          <input type="submit" value="Login">
        </div>
      </form>
      <p>Don't have an account? <a href="signup.php">Click Here</a></p>
    </div>
    <div class="box5"> <!-- Bottom box - footer box -->
      <p>Wooyoung (200468344) - Hunter (200471793) - Shahd (200490266)</p>
    </div>
  </div>
  <script src="js/eventRegisterLogin.js"></script>
</body>

</html>