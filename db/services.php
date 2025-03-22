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
 * Web service definition
 *
 * @package    local_ws_quiz_get_attempt_questions
 * @copyright  2025 Maxime Cruzel
 * @license    https://opensource.org/licenses/MIT MIT
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'local_ws_quiz_get_attempt_questions' => array(
        'classname'     => 'local_ws_quiz_get_attempt_questions\external',
        'methodname'    => 'get_attempt_questions',
        'description'   => 'Get the list of questions for a specific quiz attempt',
        'type'         => 'read',
        'capabilities' => 'mod/quiz:attempt',
        'ajax'         => true,
    )
); 