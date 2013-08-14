<?php

// This file is part of the Kamedia GPS course format for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * GPS Format free. Restrict access to topics according to user's geolocation.
 *
 * @package format_gps
 * @copyright 2013 Barry Oosthuizen
 * @author Barry Oosthuizen
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../../../../config.php');

// get HTML5 geolocation data as populated on geo div
list($user_lat, $user_long) = explode(',', htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))));
$courseid = 2;
$section = 1;
$topic = $DB->get_record('format_gps', array("courseid"=>$courseid, "section"=>$section));

$loc_lat = $topic->latitude;
$loc_long = $topic->longitude;
$loc_radius = $topic->radius;
$loc_unit = $topic->unit;

// start of radius draw code
$earthRadiuses = array(
    // The radius of the earth in various units
    'mi' => 3963.1676, // miles
    'km' => 6378.1, // kilometers
    'ft' => 20925524.9, // feet
    'mt' => 6378100, // meters
    'yd' => 6975174.98 // yards
);

$distance = getDistance($user_lat, $user_long, $loc_lat, $loc_long, $earthRadiuses[$loc_unit]);

if ($distance > $loc_radius) {
    // user is to far away
    echo 'you are too far away from the required location';
    
} else {
    // user is within allowed radius
    echo 'welcome!!!';
}

function getDistance($latitude1, $longitude1, $latitude2, $longitude2, $earth_radius) {

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return $d;
}

?>