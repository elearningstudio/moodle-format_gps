<?php
// This file is part of the GPS free course format for Moodle - http://moodle.org/
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

defined('MOODLE_INTERNAL') || die();

function format_gps_edit_icon($courseid, $sectionid) {
    global $OUTPUT, $PAGE;

    static $editstr = null;
    static $canedit = null;

    if (!$PAGE->user_is_editing()) {
        return '';
    }

    if ($canedit === null) {
        $context = context_course::instance($courseid);
        $canedit = has_capability('format/gps:editsection_geo', $context);
    }

    if (!$canedit) {
        return '';
    }

    if ($editstr === null) {
        $editstr = get_string('editsection_geo', 'format_gps');
    }

    $editurl = new moodle_url('/course/format/gps/geocoder.php', array('courseid' => $courseid, 'section' => $sectionid));
    $output = '';
    $icon = $OUTPUT->pix_icon('geo', $editstr, 'format_gps', array('title' => $editstr));
    $output .= html_writer::link($editurl, $icon, array('class' => 'format_gps_editsection_geo'));

    return $output;
}

function format_gps_add_javascript($courseid, $numsections) {
    global $PAGE;

    $jsmodule = array(
        'name' => 'format_gps',
        'fullpath' => new moodle_url('/course/format/gps/geo_map.js'),
        'strings' => array(array('format_gps'), array('format_gps'), array('cancel', 'core')),
        'requires' => array('node', 'event', 'panel')
    );
    $options = array('courseid' => $courseid, 'numsections' => $numsections);
    $PAGE->requires->js_init_call('M.geo_map.init', array($options), true, $jsmodule);
}

/**
 * Returns the 'GPS topic status' help icon
 *
 * @return string HTML code for help icon, or blank if not needed
 */
function format_gps_icon() {
    global $PAGE, $OUTPUT;

    $previewstr = get_string('gps_restricted', 'format_gps');

    $icon = $OUTPUT->pix_icon('geo', $previewstr, 'format_gps', array('title' => $previewstr));

    return $icon;
}

function format_gps_check_proximity($topic, $location) {

    $proximity = new stdClass();

    $locationlatitude = $topic->format_gps_latitude;
    $locationlongitude = $topic->format_gps_longitude;
    $locationradius = 50;
    $locationunit = 'mt';
    $userlatitude = $location->latitude;
    $userlongitude = $location->longitude;

    // Start of radius draw code.
    $earthradiuses = array(
        // The radius of the earth in various units.
        'mi' => 3963.1676, // Miles.
        'km' => 6378.1, // Kilometers.
        'ft' => 20925524.9, // Feet.
        'mt' => 6378100, // Meters.
        'yd' => 6975174.98 // Yards.
    );

    $distance = format_gps_get_distance($userlatitude, $userlongitude,
            $locationlatitude, $locationlongitude, $earthradiuses[$locationunit]);

    if ($distance > $locationradius) {
        // User is to far away.
        $proximity->status = 'toofar';
    } else {
        // User is within allowed radius.
        $proximity->status = 'ok';
    }
    return $proximity;
}

function format_gps_get_distance($latitude1, $longitude1, $latitude2, $longitude2, $earthradius) {

    $latitudedifference = deg2rad($latitude2 - $latitude1);
    $longitudedifference = deg2rad($longitude2 - $longitude1);

    $a = sin($latitudedifference / 2) * sin($latitudedifference / 2) + cos(deg2rad($latitude1))
    * cos(deg2rad($latitude2)) * sin($longitudedifference / 2) * sin($longitudedifference / 2);
    $c = 2 * asin(sqrt($a));
    $distance = $earthradius * $c;

    return $distance;
}
