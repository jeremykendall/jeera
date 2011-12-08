CREATE USER 'jeerauser'@'localhost' IDENTIFIED BY 'jeerapass';
GRANT SELECT ,
INSERT ,
UPDATE ,
DELETE ,
CREATE ,
DROP ON `jeeradb` . * TO 'jeerauser'@'localhost';
FLUSH PRIVILEGES;