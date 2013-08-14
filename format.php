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
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/completionlib.php');

$elapsedtime = time() - 300; // check that geo location was taken within the last 5 minutes (300 seconds)

if ($location = $DB->get_record_select('format_gps_user', "userid = $USER->id AND timemodified > $elapsedtime")) {

// Horrible backwards compatible parameter aliasing..
    if ($topic = optional_param('topic', 0, PARAM_INT)) {
        $url = $PAGE->url;
        $url->param('section', $topic);
        debugging('Outdated topic param passed to course/view.php', DEBUG_DEVELOPER);
        redirect($url);
    }
// End backwards-compatible aliasing..

    $context = context_course::instance($course->id);

    if (($marker >= 0) && has_capability('moodle/course:setcurrentsection', $context) && confirm_sesskey()) {
        $course->marker = $marker;
        course_set_marker($course->id, $marker);
    }

// make sure all sections are created
    $course = course_get_format($course)->get_course();
    course_create_sections_if_missing($course, range(0, $course->numsections));

    $renderer = $PAGE->get_renderer('format_gps');

    if (!empty($displaysection)) {
        $renderer->print_single_section_page($course, null, null, null, null, $displaysection);
    } else {
        $renderer->print_multiple_section_page($course, null, null, null, null);
    }

    // Include course format js module
    $PAGE->requires->js('/course/format/gps/format.js');

} else {
    $url = new moodle_url('/course/format/gps/redirect.php', array('courseid' => $course->id));
    redirect($url);

}


