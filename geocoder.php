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

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');
global $CFG, $DB, $PAGE, $OUTPUT;
require_once($CFG->dirroot . '/course/format/gps/geocoder_form.php');
require_once($CFG->dirroot . '/course/lib.php');

$courseid = required_param('courseid', PARAM_INT);
$section = required_param('section', PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$course = course_get_format($course)->get_course();

if ($section < 0 || $section > $course->numsections) {
    throw new moodle_exception('invalidsection', 'format_gps');
}

$PAGE->set_url(new moodle_url('/course/format/gps/geocoder.php', array('courseid' => $course->id, 'section' => $section)));
$PAGE->requires->css('/course/format/gps/geocoder_form.css');
require_login($course);
$context = context_course::instance($course->id);
require_capability('format/gps:editsection_geo', $context);

$courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
$custom = array('section' => $section, 'courseid' => $course->id);
$currdata = $DB->get_record('format_gps', array('courseid' => $course->id, 'section' => $section));
$form = new format_gps_editgeo_form(null, $custom);

if ($currdata) {
    $form->set_data($currdata);
}

if ($form->is_cancelled()) {
    redirect($courseurl);
}

if ($data = $form->get_data()) {
	if (!array_key_exists('active', $data)) {
		$data->active = "0";
	}
    $data->radius = '100';
    $data->unit = 'mt';
    if ($currdata) {
        $data->id = $currdata->id;
        $DB->update_record('format_gps', $data);
    } else {
        $DB->insert_record('format_gps', $data);
    }

    redirect($courseurl);
}

$PAGE->set_pagelayout('standard');
$PAGE->set_title($course->shortname . ': ' . get_string('editgeolocation', 'format_gps'));
$PAGE->set_heading($course->fullname);
$PAGE->set_cacheable(false);

echo $OUTPUT->header();

echo $OUTPUT->heading_with_help(get_string('editsection_geo_heading', 'format_gps', $section), 'pluginname', 'format_gps');

$form->display();

echo $OUTPUT->footer();
