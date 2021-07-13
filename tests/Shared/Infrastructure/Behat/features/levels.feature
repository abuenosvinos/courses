Feature: List of levels
  In order to understand how the searcher works
  As a user
  I need to see all the levels of the application

 # Background:
 #   Given the data of the fixtures is loaded

  Scenario: Get all the levels in the application
    Given I don't have a token to enter access to the system
    And I send a GET request to "/api/levels"
    Then the response status code should be 401

  Scenario: Get all the levels in the application
    Given I have a token to enter access to the system
    And I send a GET request to "/api/levels"
    Then the response status code should be 200
    And the response content should be:
    """
    {
        "_links": {
            "self": "http://localhost/api/levels"
        },
        "total": 3,
        "results": [
            {
                "name": "Nivel 1",
                "slug": "nivel-1"
            },
            {
                "name": "Nivel 2",
                "slug": "nivel-2"
            },
            {
                "name": "Nivel 3",
                "slug": "nivel-3"
            }
        ]
    }
    """