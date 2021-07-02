Feature: List of categories
  In order to understand how the searcher works
  As a user
  I need to see all the categories of the application

 # Background:
 #   Given the data of the fixtures is loaded

  Scenario: Get all the categories in the application
    Given I don't have a token to enter access to the system
    And I send a GET request to "/categories"
    Then the response status code should be 401

  Scenario: Get all the levels in the application
    Given I have a token to enter access to the system
    And I send a GET request to "/categories"
    Then the response status code should be 200
    And the response content should be:
    """
    {
        "_links": {
            "self": "http://localhost/categories"
        },
        "total": 3,
        "results": [
            {
                "name": "Categoría 1",
                "slug": "categoria-1"
            },
            {
                "name": "Categoría 2",
                "slug": "categoria-2"
            },
            {
                "name": "Categoría 3",
                "slug": "categoria-3"
            }
        ]
    }
    """