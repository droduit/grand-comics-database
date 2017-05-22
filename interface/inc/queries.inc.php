<?php
// Descriptions of queries
$q = array(
	// queries deliverable 2
	array(
	'a' => array(
			"Print the brand group names with the highest number of Belgian indicia publishers",
			"SELECT name FROM brand_group WHERE publisher_id = (
				SELECT p.id FROM indicia_publisher as ind  
				LEFT JOIN publisher as p ON ind.publisher_id = p.id
				WHERE ind.country_id = (SELECT id FROM country WHERE name = 'Belgium')
				GROUP BY p.id
				ORDER BY count(p.id) DESC
				LIMIT 1
			)"
		),
		
		'b' => array(
			"Print the ids and names of publishers of Danish book series.",
			"SELECT id, name FROM publisher WHERE id IN (
				SELECT publisher_id FROM series  
				WHERE country_id = (SELECT id FROM country WHERE name = 'Denmark')
			)
			"
		), 
		
		'c' => array(
			"Print the names of all Swiss series that have been published in magazines.",
			"SELECT name FROM series WHERE
			country_id = (SELECT id FROM country WHERE code = 'ch') AND
			publication_type_id = (SELECT id FROM series_publication_type WHERE name = 'magazine')
			"
		), 
		
		'd' => array(
			"Starting from 1990, print the number of issues published each year",
			"SELECT YEAR(publication_date) as years, count(id) as number FROM issue
			WHERE YEAR(publication_date) >= 1990
			GROUP BY years
			ORDER BY publication_date ASC
			"
		), 
		
		'e' => array(
			"Print the number of series for each indicia publisher whose name resembles ‘DC comics’.",
			"SELECT ind.name as name, count(ind.id) as nb_series FROM indicia_publisher ind
			LEFT JOIN series s ON s.publisher_id = ind.publisher_id 
			WHERE ind.name LIKE '%DC comics%'
			GROUP BY ind.name
			"
		), 
		
		'f' => array(
			"Print the titles of the 10 most reprinted stories",
			"SELECT s.title FROM story_reprint sr 
			LEFT JOIN story s ON sr.origin_id = s.id
			GROUP BY s.id
			ORDER BY COUNT(s.id) DESC
			LIMIT 10
			"
		), 
		
		'g' => array(
			"Print the artists that have scripted, drawn, and colored at least one of the stories they were involved in.",
			"SELECT distinct concat(firstname, ' ', lastname) FROM person WHERE id IN (
				SELECT person_id FROM participate
				WHERE role IN ('script', 'pencil', 'ink', 'color')
				GROUP BY person_id, story_id
				HAVING count(person_id) = 4
			)
			"
		), 
		
		'h' => array(
			"Print all non-reprinted stories involving Batman as a non-featured character.",
			"SELECT * FROM story s
			LEFT JOIN story_reprint sr ON sr.origin_id = s.id 
			WHERE sr.origin_id IS NULL AND s.id IN (
				SELECT c.story_id FROM hero h
				LEFT JOIN `character` c ON c.hero_id = h.id
				RIGHT JOIN feature f ON f.story_id = c.story_id AND  f.hero_id != h.id
				WHERE h.name = 'Batman'
				GROUP BY c.story_id
			)
			"
		)
	),
	
	// queries deliverable 3
	array(
		'a' => array(
			"Print the series names that have the highest number of issues which contain a story whose type (e.g., cartoon) is not the one occurring most frequently in the database (e.g, illustration).",
			""
		),
		
		'b' => array(
			"Print the names of publishers who have series with all series types. ",
			""
		),
		
		'c' => array(
			"Print the 10 most-reprinted characters from Alan Moore's stories. ",
			""
		),
		
		'd' => array(
			"Print the writers of nature-related stories that have also done the pencilwork in all their nature-related stories. ",
			""
		),
		
		'e' => array(
			"For each of the top-10 publishers in terms of published series, print the 3 most popular languages of their series. ",
			""
		),
		
		'f' => array(
			"Print the languages that have more than 10000 original stories published in magazines, along with the number of those stories. ",
			""
		),
		
		'g' => array(
			"Print all story types that have not been published as a part of Italian magazine series. ",
			""
		),
		
		'h' => array(
			"Print the writers of cartoon stories who have worked as writers for more than one indicia publisher. ",
			""
		),
		
		'i' => array(
			"Print the 10 brand groups with the highest number of indicia publishers. ",
			""
		),
		
		'j' => array(
			"Print the average series length (in terms of years) per indicia publisher. ",
			""
		),
		
		'k' => array(
			"Print the top 10 indicia publishers that have published the most single-issue series. ",
			""
		),
		
		'l' => array(
			"Print the 10 indicia publishers with the highest number of script writers in a single story",
			""
		),
		
		'm' => array(
			"Print all Marvel heroes that appear in Marvel-DC story crossovers. ",
			""
		),
		
		'n' => array(
			"Print the top 5 series with most issues ",
			""
		),
		
		'o' => array(
			"Given an issue, print its most reprinted story. ",
			""
		)
	)
);
?>