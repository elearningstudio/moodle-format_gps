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
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');

global $USER, $DB;

// get HTML5 geolocation data as populated on geo div
list($user_lat, $user_long) = explode(',', htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))));

$location = new stdClass();
$location->userid = $USER->id;
$location->latitude = $user_lat;
$location->longitude = $user_long;
$location->timemodified = time();
$current_record = new stdClass();

if (!$current_record = $DB->get_record('format_gps_user', array("userid" => $USER->id,))) {
    $insert = $DB->insert_record('format_gps_user', $location);
} else {
    $location->id = $current_record->id;
    $update = $DB->update_record('format_gps_user', $location);
}
?>