<?php
session_start();
require_once('db.php');

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
    LIMIT 20
    ";

    $result = $conn->query($query);
    

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>CS 215 Webpage</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="container">
        <div class="box1">
            <header>
                <ul class="navigation">
                    <li class="navigation"><a href="main_al.php"><img src="images/logo.png" alt="Image of logo" class="logo"/></a></li>
                    <li class="navigation" id="heading">Main Page</li>
                    <li class="navigation"><a href="qManagement.php"><img src="images/avatar.png" alt="Avatar" class="avatar"></a></li>
                    <li class="navigation" style="float:right"><a class="screenName" href="qManagement.php">UserName</a></li>
                </ul>
            </header>
        </div>
        <div class="box2"> <!-- Right-most box -->
            <form name="Logout" action="main_bl.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div class="box3"> <!-- Center box - holds main content -->
            <?php while ($row = $result->fetch()): ?>
                <div class="questionBox">
                    <h2><?php echo htmlspecialchars($row['questionContent']); ?></h2>
                    <p><?php echo htmlspecialchars($row['questionTimestamp']); ?></p>
                    <p>Answers: <?php echo $row['answerCount']; ?></p>
                    <img src="images/thumbsUp.jpg" class="like" />
                    <img src="images/thumbsDown.jpg" class="like" />
                    <a href="qDetail.php? questionID=<?php echo $row['questionID']; ?>" class="details">Details</a>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="box5"> <!-- Bottom box - footer box -->
            <p>Wooyoung (200468344) - Shahd (200490266) - Hunter (200471793)</p>
        </div>
    </div>
</body>

</html>
