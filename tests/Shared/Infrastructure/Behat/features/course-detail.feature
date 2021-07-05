Feature: Get the detail of a course
  In order to know the information of a course
  As a user
  I need to get that information using the detail url

 # Background:
 #   Given the data of the fixtures is loaded

  Scenario: Get the information of a course
    Given I don't have a token to enter access to the system
    And I send a GET request to "/courses/aprende-a-bailar-al-estilo-mas-funky"
    Then the response status code should be 401

  Scenario: Get the information of a course
    Given I have a token to enter access to the system
    And I send a GET request to "/courses/este-curse-no-existe"
    Then the response status code should be 404
    And the response content should be:
    """
    {
        "data": [],
        "error": {
            "message": "Course not found"
        }
    }
    """

  Scenario: Get the information of a course
    Given I have a token to enter access to the system
    And I send a GET request to "/courses/titulo-de-prueba-1"
    Then the response status code should be 200
    And the response content should be:
    """
    {
        "_links": {
            "self": "http://localhost/courses/titulo-de-prueba-1"
        },
        "data": {
            "title": "Título de prueba 1",
            "description": "Descripción de prueba 1",
            "categories": [
                {
                    "name": "Categoría 1"
                }
            ],
            "level": "Nivel 2",
            "prices": [
                {
                    "price": 100,
                    "code": "EUR"
                },
                {
                    "price": 110,
                    "code": "USD"
                }
            ]
        }
    }
    """