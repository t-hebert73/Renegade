USE renegade;
CREATE TABLE IF NOT EXISTS users
(
userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
email varchar(50) NOT NULL,
password varchar(50) NOT NULL,
auth int DEFAULT 0,
creationDate timestamp NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS jobs
(
jobID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
userID int NOT NULL,
jobName varchar(50) NOT NULL,
description text NULL,
creationDate timestamp DEFAULT NOW(),
FOREIGN KEY (userID) REFERENCES users(userID)
);

CREATE TABLE IF NOT EXISTS files
(
fileID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
jobID int NOT NULL ,
fileName varchar(50) NOT NULL,
filePath text NOT NULL,
fileDescription text NULL,
creationDate timestamp NOT NULL DEFAULT NOW(),
expiryDate date NULL,
FOREIGN KEY (jobID) REFERENCES jobs(jobID)
);