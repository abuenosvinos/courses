Feature: Search of courses
  In order to know the offer of courses
  As a user
  I need to use the parametrization of the search to find a suitable course

 # Background:
 #   Given the data of the fixtures is loaded

  Scenario: Get all the courses
    Given I don't have a token to enter access to the system
    And I send a GET request to "/api/courses"
    Then the response status code should be 401

  Scenario: Get all the courses
    Given I have a token to enter access to the system
    And I send a GET request to "/api/courses"
    Then the response status code should be 200
    And the response content should be:
    """
    {
        "_links": {
            "self": "http://localhost/api/courses",
            "prev": "http://localhost/api/courses",
            "next": "http://localhost/api/courses?page=2"
        },
        "total": 20,
        "page": 1,
        "limit": 3,
        "results": [
            {
                "_links": {
                    "self": "http://localhost/api/courses/titulo-de-prueba-12"
                },
                "title": "Título de prueba 12",
                "description": "Descripción de prueba 12",
                "startAt": "2021-10-25 10:00:00",
                "categories": [],
                "level": "Nivel 1",
                "prices": [
                    {
                        "price": 1200,
                        "code": "EUR"
                    },
                    {
                        "price": 1210,
                        "code": "USD"
                    }
                ]
            },
            {
                "_links": {
                    "self": "http://localhost/api/courses/titulo-de-prueba-15"
                },
                "title": "Título de prueba 15",
                "description": "Descripción de prueba 15",
                "startAt": "2021-10-25 10:00:00",
                "categories": [],
                "level": "Nivel 1",
                "prices": [
                    {
                        "price": 1500,
                        "code": "EUR"
                    },
                    {
                        "price": 1510,
                        "code": "USD"
                    }
                ]
            },
            {
                "_links": {
                    "self": "http://localhost/api/courses/titulo-de-prueba-18"
                },
                "title": "Título de prueba 18",
                "description": "Descripción de prueba 18",
                "startAt": "2021-10-25 10:00:00",
                "categories": [],
                "level": "Nivel 1",
                "prices": [
                    {
                        "price": 1800,
                        "code": "EUR"
                    },
                    {
                        "price": 1810,
                        "code": "USD"
                    }
                ]
            }
        ]
    }
    """