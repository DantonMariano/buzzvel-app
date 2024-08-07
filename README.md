
# Buzzvel Application

Hi and welcome to my Buzzvel Application project! a project that allow users to perform Create, Read, Update and Delete operations on holiday plans, and also exports to PDF.


# Get Started

Step-by-step guide on how to start the project

1. run `git clone git@github.com:DantonMariano/buzzvel-app.git`
2. after that ensure you are in the right directory using `cd buzzvel-app`
3. run `composer install`
4. copy the contents of .env.example to .env and do the changes according to your necessities
5. run `php artisan key:generate`
6. run `php artisan migrate`
6. after that serve the program using `php artisan serve`
7. enjoy! 

# Endpoints
Down below you will find a list containing all the endpoints for the API.
## GET /holidays
returns a list with all holidays for the authenticated user.

Example Request:
    
    GET /api/holidays
Example response
    
    [
    {
        "id": 1,
        "title": "Holiday 1",
        "description": "Description for holiday 1",
        "location": "Location 1",
        "date": "2024-08-01",
        "participants": 10,
        "user_id": 1
    },
    ...
    ]

## POST /holidays
creates a new holiday for the authenticated user

Example request:
        
    POST /api/holidays
    Content-Type: application/json

    {
        "title": "Holiday Title",
        "description": "Holiday Description",
        "location": "Holiday Location",
        "date": "2024-12-25",
        "participants": 5
    }

Example response: 

    {
        "id": 1,
        "title": "Holiday Title",
        "description": "Holiday Description",
        "location": "Holiday Location",
        "date": "2024-12-25",
        "participants": 5,
        "user_id": 1
    }

## GET /holidays/{id}
returns a specific holiday for the authenticated user

Example request:
    
    GET /api/holidays/1

Example response: 

    {
        "id": 1,
        "title": "Holiday Title",
        "description": "Holiday Description",
        "location": "Holiday Location",
        "date": "2024-12-25",
        "participants": 5,
        "user_id": 1
    }

## PUT /holidays/{id}
Updates a specific holiday for the authenticated user.

Example Request:
    PUT /api/holidays/1
    Content-Type: application/json

    {
        "title": "Updated Holiday Title",
        "description": "Updated Holiday Description",
        "date": "2024-12-26",
        "participants": 10
    }

Example Response:

    {
        "id": 1,
        "title": "Updated Holiday Title",
        "description": "Updated Holiday Description",
        "location": "Holiday Location",
        "date": "2024-12-26",
        "participants": 10,
        "user_id": 1
    }

## DELETE /holidays/{id}

Deletes a specific holiday Entry for the authenticated user.

Example request:
    
    DELETE /api/holidays/1

Example response:

    {
        "message": "Holiday deleted successfully."
    }

## GET /download

Generates a PDF containing all the holidays summarized.

Example request:

    GET /api/download

### Validation Rules for Holiday entity
title: required, string

description: required, string

location: required, string

date: required, date

participants: integer
