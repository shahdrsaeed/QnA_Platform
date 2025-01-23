<?php

session_start();
require_once('db.php');

try {
  $conn = new PDO($attr, $db_user, $db_pwd, $options);

  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Assuming 'Users' table is joined with 'Questions' to fetch questions by username
    $query = "
    SELECT
    Q.content,
    Q.timestamp,
    A.content,
    A.timestamp,
    U.username,
    (SELECT COUNT(*) FROM Vote WHERE upVote = 1) AS UpvoteCount,
    (SELECT COUNT(*) FROM Vote WHERE downVote = 1) AS DownvoteCount
    FROM Questions AS Q
    LEFT JOIN Answer AS A ON Q.questionID = A.questionID
    LEFT JOIN User AS U ON Q.userID = U.userID
    WHERE U.username = :username
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

} catch (PDOException $e) {
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
    </head>

    <body>
        <div class="container">
            <div class="box1"> <!-- Top most box - box for header items -->
                <header>
                  <ul class="navigation">
                    <li class="navigation"><a href="main_al.html"><img src="images/logo.png" alt="Image of logo" class="logo"/></a></li>
                    <li class="navigation" id="heading">Question Management</li>
                    <li class="navigation"><a href="qManagement.html"><img src="images/avatar.png" alt="Avatar" class="avatar"></a></li>
                    <li class="navigation" style="float:right"><a class="screenName" href="qManagement.html">UserName</a></li>
                  </ul>
                </header>
            </div>


            <div class="box2"> <!-- Left-most box - includes 'Logout' Button -->
              <form name="Logout" action="main_bl.html" method="POST">
                  <button type="submit">Logout</button>
              </form>
            </div>


            <div class="box3"> <!-- Center box - holds main content -->
              <div class="questionBox">
                <p>Jan/27/2024 1:00AM</p>
                <p> Votes: 42 </p>
                <p><b>Question</b>:  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                    an unknown printer took a galley of type and scrambled it to make a type specimen
                    book. </p>
                <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                <img src="images/thumbsDown.jpg" alt="downvote" class="like">
              </div>
              <div class="answerBox">
                <img src="images/avatar.png" alt="avatar" class="ansAvatar">
                <p class="ansAvatar">screenName - Jan/27/2024 1:00AM</p>
                <p style="margin-top: 85px">Ipsum has been the industry's standard dummy text ever since the 1500s, whe an unknown printe</p>
                <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                <img src="images/thumbsDown.jpg" alt="downvote" class="like">
              </div>
              

              <div class="questionBox">
                <p>Jan/27/2024 1:00AM</p>
                <p> Votes: 42 </p>
                <p><b>Question</b>:  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                    an unknown printer took a galley of type and scrambled it to make a type specimen
                    book. </p>
                <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                <img src="images/thumbsDown.jpg" alt="downvote" class="like">
              </div>
              <div class="answerBox">
                <img src="images/avatar.png" alt="avatar" class="ansAvatar">
                <p class="ansAvatar">screenName - Jan/27/2024 1:00AM</p>
                <p style="margin-top: 85px">Ipsum has been the industry's standard dummy text ever since the 1500s, whe an unknown printe</p>
                <img src="images/thumbsUp.jpg" alt="upvote" class="like">
                <img src="images/thumbsDown.jpg" alt="downvote" class="like">
              </div>
            </div>


            <div class="box4"> <!-- Right-most box - includes 'Question Creation' Button -->
              <form name="qCreate" action="qCreation.html" method="POST">
                  <button type="submit">Create Question</button>
              </form>
            </div>

            <div class="box5"> <!-- Bottom box - footer box -->
              <p>Wooyoung (200468344) - Hunter (200471793) - Shahd (200490266)</p>
            </div>
        </div>
    </body>
</html>