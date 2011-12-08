DROP DATABASE IF EXISTS jeeradb;
CREATE DATABASE jeeradb;
USE jeeradb;

CREATE TABLE IF NOT EXISTS users (
userId int(10) unsigned NOT NULL AUTO_INCREMENT,
username varchar(50) NOT NULL,
salt varchar(22) NOT NULL,
passwordHash varchar(40) NOT NULL,
userRole varchar(20) NOT NULL,
firstName varchar(50) NOT NULL,
lastName varchar(50) NOT NULL,
department varchar(50) NOT NULL,
created datetime NOT NULL,
updated datetime  NOT NULL
) CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tickets (
ticketId int(10) unsigned NOT NULL AUTO_INCREMENT,
problemType varchar(100) NOT NULL,
problemDescription text NOT NULL,
impact varchar(30) NOT NULL,
assignedTo int(10) unsigned NOT NULL,
status varchar(30) NOT NULL,
notes text,
createdBy int(10) unsigned NOT NULL,
createdDate datetime,
lastUpdatedBy int(10) unsigned NOT NULL,
lastUpdatedDate datetime
) CHARSET=utf8;
