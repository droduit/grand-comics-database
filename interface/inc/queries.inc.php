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
			"SELECT distinct name FROM person WHERE id IN (
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
				LEFT JOIN characters c ON c.hero_id = h.id
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
			"SELECT name, temp.nb FROM series se
			INNER JOIN (
				SELECT series_id, COUNT(*) AS nb FROM issue
				INNER JOIN (
					SELECT distinct issue_id as iid FROM story
					WHERE type_id != (
						SELECT type_id FROM story
						GROUP BY type_id
						ORDER BY count(*) DESC
						LIMIT 1
					)
				) st ON issue.id = st.iid
				GROUP BY series_id
			) as temp ON se.id = temp.series_id
			ORDER BY temp.nb DESC
			"
		),
		
		'b' => array(
			"Print the names of publishers who have series with all series types. ",
			"SELECT p.name
			FROM publisher as p
			WHERE (
				SELECT COUNT(distinct sp.name) FROM series as s
				LEFT JOIN series_publication_type as sp ON sp.id = s.publication_type_id
				WHERE s.publisher_id = p.id
			) =	(
				SELECT COUNT(distinct sp.name)
				FROM series_publication_type as sp
			)"
		),
		
		'c' => array(
			"Print the 10 most-reprinted characters from Alan Moore's stories. ",
			"SELECT h.name FROM (
				SELECT charac.hero_id, COUNT(*) as nb
				FROM story_reprint sr
				LEFT JOIN story s ON s.id = sr.origin_id
				LEFT JOIN characters charac ON charac.story_id = s.id
				LEFT JOIN participate part ON part.story_id = s.id AND part.role = 'script'
				LEFT JOIN person pers ON pers.id = part.person_id 
				WHERE pers.name LIKE '%alan moore%'
				GROUP BY charac.hero_id
			) as interm
			LEFT JOIN hero h ON h.id = interm.hero_id
			ORDER BY interm.nb DESC
			LIMIT 10
			"
		),
		
		'd' => array(
			"Print the writers of nature-related stories that have also done the pencilwork in all their nature-related stories. ",
			""
		),
		
		'e' => array(
			"For each of the top-10 publishers in terms of published series, print the 3 most popular languages of their series. ",
			"SELECT l.name, count(*) as nb FROM series se
			LEFT JOIN (
				SELECT p.id, COUNT(p.id) as num FROM series s
				LEFT JOIN publisher p ON s.publisher_id = p.id
				GROUP BY p.id DESC
				ORDER BY COUNT(p.id) DESC
				LIMIT 10
			) as temp ON temp.id = se.publisher_id 
			LEFT JOIN language l ON l.id = se.language_id
			GROUP BY l.id
			ORDER BY nb DESC
			LIMIT 3"
		),
		
		'f' => array(
			"Print the languages that have more than 10000 original stories published in magazines, along with the number of those stories. ",
			"SELECT temp.name, temp.nb FROM (
				SELECT distinct l.name, COUNT(*) as nb
				FROM language l,
					 series se,
					 story s, 
					 issue i
				WHERE l.id = se.language_id AND
					 se.id = i.series_id AND
					 i.id = s.issue_id AND
					 se.publication_type_id = (SELECT id FROM series_publication_type WHERE name = 'magazine') AND
					 (SELECT COUNT(*) FROM story_reprint sr WHERE sr.target_id = s.id) = 0
				GROUP BY l.name
			) as temp
			WHERE temp.nb >= 10000
			ORDER BY temp.nb DESC"
		),
		
		'g' => array(
			"Print all story types that have not been published as a part of Italian magazine series. ",
			"SELECT distinct st.name FROM story s
			LEFT JOIN story_type st ON st.id = s.type_id
			LEFT JOIN (
				SELECT i.id FROM issue i 
				RIGHT JOIN (
					SELECT se.id FROM series se WHERE
					se.language_id != (SELECT id FROM language WHERE code = 'it') AND 
					se.publication_type_id = (SELECT id FROM series_publication_type WHERE name='magazine')
				) as temp ON temp.id = i.series_id
			) as iss ON s.issue_id = iss.id"
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
			"SELECT name, AVG(diff) as average FROM (
				SELECT ip.name, (CAST(s.year_ended AS SIGNED) - CAST(s.year_began AS SIGNED)) as diff
				FROM series s
				LEFT JOIN indicia_publisher ip ON ip.publisher_id = s.publisher_id
				WHERE year_began < year_ended AND year_began > 0 AND year_ended > 0
			) as res
			GROUP BY name
			ORDER by average DESC
			"
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
			"SELECT s.name FROM series s
			LEFT JOIN issue i ON i.series_id = s.id
			GROUP BY s.id
			ORDER BY COUNT(s.name) DESC
			LIMIT 5"
		),
		
		'o' => array(
			"Given an issue, print its most reprinted story. ",
			"" // SELECT name FROM country WHERE id=?
		)
	)
);
?>