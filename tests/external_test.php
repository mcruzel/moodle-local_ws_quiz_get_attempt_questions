<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
/**
 * Unit tests for external web service
 *
 * @package   local_ws_quiz_get_attempt_questions
 * @category  external
 * @copyright 2025 Maxime Cruzel
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace local_ws_quiz_get_attempt_questions;

use externallib_advanced_testcase;
use stdClass;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/webservice/tests/helpers.php');
require_once($CFG->dirroot . '/local/ws_quiz_get_attempt_questions/classes/external.php');

/**
 * External web service test case
 */
class external_test extends externallib_advanced_testcase {
    /**
     * Test get_attempt_questions
     */
    public function test_get_attempt_questions() {
        global $DB;
        $this->resetAfterTest(true);

        // Create a course
        $course = $this->getDataGenerator()->create_course();

        // Create a quiz
        $quiz = $this->getDataGenerator()->create_module('quiz', array(
            'course' => $course->id,
            'questionsperpage' => 0,
            'grade' => 100.0,
            'sumgrades' => 2
        ));

        // Create a user
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id, 'student');
        $this->setUser($user);

        // Create questions
        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        
        // Create first question
        $cat = $questiongenerator->create_question_category();
        $question1 = $questiongenerator->create_question('numerical', null, array('category' => $cat->id));
        $question2 = $questiongenerator->create_question('numerical', null, array('category' => $cat->id));

        // Add questions to quiz
        quiz_add_quiz_question($question1->id, $quiz);
        quiz_add_quiz_question($question2->id, $quiz);

        // Start the attempt
        $quizobj = \quiz::create($quiz->id, $user->id);
        $attempt = quiz_create_attempt($quizobj, 1, false, time());
        $attemptid = quiz_start_new_attempt($quizobj, $attempt, 1, time());
        quiz_attempt_save_started($quizobj, $attempt);

        // Call the external function
        $result = external::get_attempt_questions($attemptid);

        // Verify the results
        $this->assertCount(2, $result);
        
        // Check first question
        $this->assertEquals(1, $result[0]['slot']);
        $this->assertEquals($question1->id, $result[0]['questionid']);
        
        // Check second question
        $this->assertEquals(2, $result[1]['slot']);
        $this->assertEquals($question2->id, $result[1]['questionid']);
    }

    /**
     * Test get_attempt_questions with invalid attempt
     */
    public function test_get_attempt_questions_invalid_attempt() {
        $this->resetAfterTest(true);
        
        $this->expectException('moodle_exception');
        external::get_attempt_questions(-1);
    }
} 