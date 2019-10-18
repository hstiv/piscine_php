SELECT UPPER(last_name) AS `NAME`, first_name, price from `member` 
INNER join subscription ON `member`.id_sub = subscription.id_sub
INNER join user_card ON `member`.id_user_card=user_card.id_user
WHERE price > 42 ORDER BY last_name, first_name ASC;