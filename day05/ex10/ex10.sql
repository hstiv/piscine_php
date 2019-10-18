select title AS `Title`, summary AS `Summary`, prod_year from film 
inner join genre on film.id_genre = genre.id_genre 
where genre.name = 'erotic' ORDER BY prod_year DESC;