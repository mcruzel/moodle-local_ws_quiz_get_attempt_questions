<?php
// This file is part of Moodle - http://moodle.org/
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
 * Version details
 *
 * @package   local_ws_quiz_get_attempt_questions
 * @copyright 2025 Maxime Cruzel
 * @license   https://opensource.org/licenses/MIT MIT
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2025030105;        // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2022112800;        // Requires this Moodle version.
$plugin->component = 'local_ws_quiz_get_attempt_questions'; // Full name of the plugin (used for diagnostics).
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.0.5'; 