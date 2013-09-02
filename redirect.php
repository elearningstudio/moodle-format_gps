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

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');
global $CFG, $DB, $PAGE, $OUTPUT;
require_once($CFG->dirroot . '/course/lib.php');

$courseid = required_param('courseid', PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$course = course_get_format($course)->get_course();

$PAGE->set_url(new moodle_url('/course/format/gps/redirect.php', array('courseid' => $courseid)));
$PAGE->requires->css('/course/format/gps/styles.css');
require_login($course);

echo $OUTPUT->header();
$PAGE->set_pagelayout('standard');
$PAGE->set_title($course->shortname . ': ' . get_string('sharelocation', 'format_gps'));
$PAGE->set_heading(get_string('sharelocation', 'format_gps'));

echo '<div id="geo" class="geolocation_data"></div>';

$PAGE->requires->js('/course/format/gps/geo/geo.js');

$redirect = new moodle_url('/course/view.php', array('id' => $courseid));
$link = html_writer::link($redirect, get_string('continue', 'format_gps'), array('class' => 'gps-continue'));

echo $link;
echo $OUTPUT->footer();
