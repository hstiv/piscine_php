SELECT film.id_genre , genre.name, film.id_distrib, distrib.name, film.title FROM film
LEFT JOIN distrib ON film.id_distrib = distrib.id_distrib
LEFT JOIN genre ON film.id_genre=genre.id_genre
WHERE film.id_genre BETWEEN 4 AND 8;