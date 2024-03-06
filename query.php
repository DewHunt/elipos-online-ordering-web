<?php
	$distance_between_two_postcode = "
	SELECT *, ROUND(DEGREES(ACOS(LEAST(1.0,SIN(RADIANS(52.577994)) * SIN(RADIANS(`latitude`)) + COS(RADIANS(52.577994)) * COS(RADIANS(`latitude`)) * COS(RADIANS(-1.884885 - `longitude`))))) * 60 * 1.1515,2) AS distance_in_mile
	FROM `postcode`
	ORDER BY distance_in_mile ASC
	";
?>