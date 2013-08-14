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

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/formslib.php');

class format_gps_editgeo_form extends moodleform {

    public function definition() {
        $mform = & $this->_form;
        $section = $this->_customdata['section'];
        $courseid = $this->_customdata['courseid'];

        $mform->addElement('header', 'general', get_string('editsection_geo_heading', 'format_gps', $section));

        $mform->addElement( 'checkbox', 'active', get_string('active', 'format_gps') );
        $mform->setDefault( 'active', 1 );

        $mform->addElement('text', 'address', get_string('address', 'format_gps'));
		$mform->setType('address', PARAM_TEXT);
		$mform->disabledIf('address', 'active', 'notchecked');

        $mform->addElement('text', 'latitude', get_string('latitude', 'format_gps'));
        $mform->addElement('text', 'longitude', get_string('longitude', 'format_gps'));
		$mform->addRule( 'latitude', null, 'required', null, 'client' );
		$mform->addRule( 'latitude', null, 'numeric', null, 'client' );
		$mform->addRule( 'longitude', null, 'required', null, 'client' );
		$mform->addRule( 'longitude', null, 'numeric', null, 'client' );
		$mform->setType('latitude', PARAM_TEXT);
		$mform->setType('longitude', PARAM_TEXT);
		$mform->disabledIf('latitude', 'active', 'notchecked');
		$mform->disabledIf('longitude', 'active', 'notchecked');

        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->addElement('hidden', 'section', $section);
		$mform->setType('courseid', PARAM_INT);
		$mform->setType('section', PARAM_TEXT);

        $this->add_action_buttons();
    }

}
