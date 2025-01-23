<?php

require_once('db.php');
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['content'])) {
    $content = trim($_POST['content']);
    
    if (empty($content) || strlen($content) > 1500) {
      header("Location: qDetail.php");
      exit();
    }

    try {
      $conn = new PDO($attr, $db_user, $db_pwd, $options);
      $stmt = $conn->prepare("INSERT INTO Answer (questionID, userID, content) VALUES (?, ?, ?)");
      
      $stmt->execute([$questionID, $_SESSION['userID'], $content]);

      header("Location: qDetail.php");
      exit();
    } 
    catch (PDOException $e) {
      header("Location: qDetail.php");
      exit();
    }
  }

  if (isset($_POST['voteType']) && isset($_POST['answerID'])) {
    $voteType = $_POST['voteType'];
    $answerId = $_POST['answerId'];
    
    try {
      $conn = new PDO($attr, $db_user, $db_pwd, $options);

      $stmt = $conn->prepare("SELECT * FROM Vote WHERE answerID = ? AND userID = ?");
      $stmt->execute([$answerID, $_SESSION['userID']]);
      $existingVote = $stmt->fetch();

      if (!$existingVote) {
        $stmt = $conn->prepare("INSERT INTO Vote (answerID, userID, vote_type) VALUES (?, ?, ?)");
        $stmt->execute([$answerId, $_SESSION['userID'], $voteType]);
      } 
      else {
        $stmt = $conn->prepare("UPDATE Vote SET vote_type = ? WHERE answerID = ? AND userID = ?");
        $stmt->execute([$voteType, $answerId, $_SESSION['userID']]);
      }
      
      header("Location: qDetail.php");
      exit();
    } 
    catch (PDOException $e) {
      header("Location: qDetail.php");
      exit();
    }
  }
}

try {
  $conn = new PDO($attr, $db_user, $db_pwd, $options);

  $stmtQuestion = $conn->prepare("
  SELECT
  Q.questionID,
  Q.content AS questionContent,
  Q.timestamp AS questionTimestamp
  FROM Question AS Q
  WHERE Q.questionID = :questionID
  ");
  
  $stmtQuestion->bindParam(':questionID', $_GET['questionID'], PDO::PARAM_INT);
  $stmtQuestion->execute();
  $questionDetails = $stmtQuestion->fetch(PDO::FETCH_ASSOC);

  $stmtAnswers = $conn->prepare("
  SELECT
  A.answerID,
  A.content as answerContent,
  A.timestamp AS answerTimestamp,
  (SELECT username FROM User) AS username,
  (SELECT COUNT(*) FROM Vote WHERE upVote = 1) AS UpvoteCount,
  (SELECT COUNT(*) FROM Vote WHERE downVote = 1) AS DownvoteCount
  FROM Answer AS A
  LEFT JOIN User AS U ON A.userID = U.userID
  WHERE A.questionID = :questionID
  ");
  
  $stmtAnswers->bindParam(':questionID', $_GET['questionID'], PDO::PARAM_INT);
  $stmtAnswers->execute();
  $answers = $stmtAnswers->fetchAll(PDO::FETCH_ASSOC);

} 
catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  die();
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
                  <li class="navigation" id="heading">Question Detail</li>
                  <li class="navigation"><a href="qManagement.php"><img src="images/avatar.png" alt="Avatar" class="avatar"></a></li>
                  <li class="navigation" style="float:right"><a class="screenName" href="qManagement.html">UserName</a></li>
                </ul>
              </header>
          </div>


          <div class="box2"> <!-- Left-most box - includes 'Logout' Button -->
            <form name="Logout" action="signup.php" method="POST">
                <button type="submit">Logout</button>
            </form>
          </div>


          <div class="box3"> <!-- Center box - holds main content -->
              <div class="questionBox">
                <p><?= $questionDetails['questionTimestamp'] ?></p>
                <p> Votes: 0 </p>
                <p><b>Question</b>: <?= $questionDetails['questionContent'] ?> </p>
                <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                <img src="images/thumbsDown.jpg" alt="downvote" class="like">
              </div>
              <?php foreach ($answers as $answer): ?>
                <div class="answerBox">
                  <img src="images/avatar.png" alt="avatar" class="ansAvatar">
                  <p class="ansAvatar"><?= $answer['username'] ?> <?= $answer['answerTimestamp'] ?></p>
                  <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                  <img src="images/thumbsDown.jpg" alt="downvote" class="like">
                  <p style="margin-top: 85px"> <?= $answer['answerContent'] ?> </p>
                </div>
              <?php endforeach; ?>
              <form class="qInputBox" action="qManagement.php" id="qDetails-form"> 
                <label for="Qdetails" style="margin-right:100%">Answer:</label>
                <textarea type="text" id="Qdetails" onkeyup="count(this);" row="6" column="80" ></textarea>
                <p id="charNum" style="float: left;">1500 characters remaining</p>
                <p id="error-text-qDetails" class="error-text hidden">Cannot be left empty.</p>
                <input type="submit" style="float: right;" value="Post">
              </form>
          </div>

          <div class="box4"> <!-- Right-most box - includes 'Question Creation' Button -->
            <form name="qCreate" action="main_al.php" method="POST">
                <button type="submit">Main Page</button>
            </form>
            <form name="qCreate" action="qManagement.php" method="POST">
                <button type="submit">Question Management</button>
            </form>
          </div>
        
          <div class="box5"> <!-- Bottom box - footer box -->
            <p>Wooyoung (200468344) - Hunter (200471793) - Shahd (200490266)</p>
          </div>
        </div>
      <script src="js/eventRegisterQdetails.js"> </script>
    </body>
</html>