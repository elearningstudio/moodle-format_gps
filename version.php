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
 * Version details for GPS Format free.
 *
 * @package    format_gps
 * @copyright  2013 Barry Oosthuizen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2013080200;        // the current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2012112900;        // minimum version number of Moodle that this plugin requires
$plugin->component = 'format_gps';    	// full name (frankenstyle) of the plugin (used for installation and upgrade diagnostics)
$plugin->maturity = MATURITY_STABLE;
$plugin->release = '1.2';