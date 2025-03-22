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
 * External Web Service Implementation
 *
 * @package    local_ws_quiz_get_attempt_questions
 * @copyright  2025 Maxime Cruzel
 * @license    https://opensource.org/licenses/MIT MIT
 */

namespace local_ws_quiz_get_attempt_questions;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

use quiz_attempt;
use external_api;
use external_function_parameters;
use external_value;
use external_multiple_structure;
use external_single_structure;

/**
 * External service implementation class
 */
class external extends external_api {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_attempt_questions_parameters() {
        return new external_function_parameters(
            array(
                'attemptid' => new external_value(PARAM_INT, 'The attempt ID')
            )
        );
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_attempt_questions_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'slot' => new external_value(PARAM_INT, 'Question slot number'),
                    'questionid' => new external_value(PARAM_INT, 'Question ID'),
                    'name' => new external_value(PARAM_TEXT, 'Question name')
                )
            )
        );
    }

    /**
     * Get questions for a specific quiz attempt
     * @param int $attemptid The attempt ID
     * @return array of questions
     */
    public static function get_attempt_questions($attemptid) {
        global $DB;

        // Parameter validation
        $params = self::validate_parameters(self::get_attempt_questions_parameters(),
            array('attemptid' => $attemptid));

        // Context validation
        $attemptobj = \quiz_attempt::create($attemptid);
        self::validate_context($attemptobj->get_context());

        // Execute the query
        $sql = "SELECT 
                    qa.slot, 
                    qa.questionid,
                    q.name
                FROM {quiz_attempts} quiza
                JOIN {question_attempts} qa ON qa.questionusageid = quiza.uniqueid
                JOIN {question} q ON q.id = qa.questionid
                WHERE quiza.id = :attemptid
                ORDER BY qa.slot";
        
        $questions = $DB->get_records_sql($sql, array('attemptid' => $attemptid));

        $result = array();
        foreach ($questions as $question) {
            $result[] = array(
                'slot' => $question->slot,
                'questionid' => $question->questionid,
                'name' => $question->name
            );
        }

        return $result;
    }
} 