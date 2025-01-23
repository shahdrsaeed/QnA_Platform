DROP TABLE IF EXISTS User, Question, Answer, Vote;

CREATE TABLE User (
    userID INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    dob Date,
    avatarUrl VARCHAR(100),
    PRIMARY KEY (userID)
);

CREATE TABLE Question (
    questionID INT AUTO_INCREMENT,
    userID INT,
    title VARCHAR(50) NOT NULL,
    content TEXT NOT NULL, 
    timestamp TIMESTAMP NOT NULL,
    FOREIGN KEY (userID) REFERENCES User(userID),
    PRIMARY KEY (questionID)
);

CREATE TABLE Answer (
    answerID INT AUTO_INCREMENT,
    questionID INT,
    userID INT,
    content TEXT NOT NULL,
    timestamp TIMESTAMP NOT NULL,
    FOREIGN KEY (questionID) REFERENCES Question(questionID),
    FOREIGN KEY (userID) REFERENCES User(userID),
    PRIMARY KEY (answerID)
);

CREATE TABLE Vote (
    voteID INT AUTO_INCREMENT,
    answerID INT,
    userID INT,
    upVote INT,
    downVote INT,
    FOREIGN KEY (answerID) REFERENCES Answer(answerID),
    FOREIGN KEY (userID) REFERENCES User(userID),
    PRIMARY KEY (voteID)
);
