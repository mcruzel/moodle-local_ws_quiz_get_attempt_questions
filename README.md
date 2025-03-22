# Quiz Attempt Questions Web Service Plugin

This Moodle plugin provides a web service to retrieve questions from a specific quiz attempt.

## Features

- Retrieves the list of questions for a given quiz attempt
- Returns question slot, ID, and name for each question
- Supports random questions in quizzes

## Installation

1. Copy the plugin directory into the `local` directory of your Moodle installation
2. Visit the notifications page to complete the installation
3. Enable web services in Moodle if not already enabled
4. Enable the new web service functions in the external services configuration

## Usage

### Web Service Endpoint

Function name: `local_ws_quiz_get_attempt_questions`

### Parameters

- `attemptid` (integer): The ID of the quiz attempt

### Returns

An array of objects containing:
- `slot` (integer): The position of the question in the quiz
- `questionid` (integer): The unique identifier of the question
- `name` (string): The name of the question

### Example Response

```json
[
    {
        "slot": 1,
        "questionid": 123,
        "name": "First Question"
    },
    {
        "slot": 2,
        "questionid": 124,
        "name": "Second Question"
    }
]
```

## Requirements

- Moodle 4.1 or later

## License

MIT License - See LICENSE file for details

## Author

- Maxime Cruzel
- Copyright 2025 