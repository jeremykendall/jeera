
INSERT INTO `tickets` (`ticketId`, `problemType`, `problemDescription`, `impact`, `assignedTo`, `status`, `notes`, `createdBy`, `createdDate`, `lastUpdatedBy`, `lastUpdatedDate`) VALUES
(100100, 'Printer Problem', 'I moved my desk and now my printer doesn''t work.  I have a report due in 10 minutes and this needs to be resolved ASAP!', 'critical', 2, 'new', 'This guy is crazy.  I''m assigning him to David.', 5, '2011-12-09 00:28:57', 5, '2011-12-09 00:44:14'),
(100101, 'Dick''s printer problem', 'I unplugged Dick''s printer because I think he''s a jerk.  He doesn''t really have a report due, but he does have some Google maps he wants to print for his fishing trip.  Don''t worry about coming down here, I''ll plug it back in in a bit.', 'minor', NULL, 'new', NULL, 4, '2011-12-09 00:41:08', 4, '2011-12-09 00:41:08'),
(100102, 'Telephone', 'I was talking to John Lithgow on the phone and we got cut off.  My phone hasn''t work since. That was about 10 minutes ago.', 'moderate', NULL, 'new', NULL, 6, '2011-12-09 00:43:03', 6, '2011-12-09 00:43:03');

INSERT INTO `users` (`userId`, `username`, `passwordHash`, `userRole`, `firstName`, `lastName`, `department`, `created`, `updated`) VALUES
(1, 'jeremy.kendall', '$2a$08$dWSgepjwrUBWNWQ1QrZm6OBI3sU2Z0V/GJ/jOPCYd9b1gQctWnaz6', 'admin', 'Jeremy', 'Kendall', 'IT', '2011-12-09 00:24:29', '2011-12-09 00:24:29'),
(2, 'david.haskins', '$2a$08$nKQ9jEncVlLOWFmMGFHABOCoKBLRx.AbiF5/.AJmS8UWjrqDZa9i2', 'admin', 'David', 'Haskins', 'IT', '2011-12-09 00:24:29', '2011-12-09 00:24:29'),
(3, 'eddie.baker', '$2a$08$tAjp6Az6rHHwLEorGpbhPu4mRjkcaQwrjtVuOGTQ60cHyFm0yoLHa', 'admin', 'Eddie', 'Baker', 'IT', '2011-12-09 00:24:29', '2011-12-09 00:24:29'),
(4, 'tom.user', '$2a$08$Lue5u.gfKoCFKDFKfoEaE.YNJQfdQUoRdc.7cqjfhEe/Ts7vrQdTq', 'user', 'Tom', 'User', 'Accounting', '2011-12-09 00:24:29', '2011-12-09 00:24:29'),
(5, 'dick.user', '$2a$08$RNiPzwFNw54YzEDVp0S1MuxNj8xFJz8hdVJHAeyJ4fjcaly0olo0m', 'user', 'Dick', 'User', 'HR', '2011-12-09 00:24:29', '2011-12-09 00:24:29'),
(6, 'harry.user', '$2a$08$yXLOdP9rnNY9jUQ6DUISauYB3UxvPL.vamo/69mBgGoRBUkYpVaLO', 'user', 'Harry', 'User', 'Marketing', '2011-12-09 00:24:29', '2011-12-09 00:24:29');