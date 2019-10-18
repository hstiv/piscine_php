SELECT COUNT(*) AS movies FROM member_history
WHERE DATE(date) BETWEEN '2006-10-30' AND '2007-07-27'
OR DATE_FORMAT(DATE(date), '%m-%d') = DATE_FORMAT('1999-12-24', "%m-%d");