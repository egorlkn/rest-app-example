FORMAT: 1A

# Task

A simple API to manage a task.

## Task list [/api/1/tasks]

### Get task list [GET]

You may get your own task list using this action.

+ Response 200 (application/json)

        [
            {
                "uuid": "dfa2db30-9de6-4210-8433-4aa5cbe14f16",
                "name": "Task one",
                "completed": true
            },
            {
                "uuid": "7ceb4b17-70bc-481a-ad3b-c713355fb323",
                "name": "Task two",
                "completed": false
            },
            {
                "uuid": "ea608a6b-9e14-475b-b818-6e33cef0a1f5",
                "name": "Task three",
                "completed": false
            }
        ]

### Add a new task to list [POST]

You may add a new task to list using this action.

+ Request (application/json)

    + Attributes (object)
        + name (string, required) - Cannot be empty
        + completed (boolean, required)

    + Body

            {
                "name": "Task four",
                "completed": false
            }

+ Response 200 (application/json)

        {
            "uuid": "49be9383-49d6-4b0c-bb4d-00c3966e74c8",
            "name": "Task four",
            "completed": false
        }

+ Response 400

## Existent task [/api/1/task/{uuid}]

+ Parameters
    + uuid (string) - UUID of the task

### Edit existent Task [PUT]

You may edit an existent task using this action.

+ Request (application/json)

    + Attributes (object)
        + name (string, required) - Cannot be empty
        + completed (boolean, required)

    + Body

            {
                "name": "Task five",
                "completed": true
            }

+ Response 200 (application/json)

        {
            "uuid": "494645a3-23b3-496c-8183-2fc9412667b9",
            "name": "Task five",
            "completed": true
        }

+ Response 400

+ Response 404

### Delete existent Task [DELETE]

You may delete an existent task using this action.

+ Response 204

+ Response 404
