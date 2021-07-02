Feature: User logged
  In order to know what information has the system
  As a user logged
  I need to see all my information

 # Background:
  #  Given the data of the fixtures is loaded

  Scenario: Get all my information
    Given I don't have a token to enter access to the system
    And I send a GET request to "/user"
    Then the response status code should be 401

  Scenario: Get all my information
    Given I have a token to enter access to the system
    And I send a GET request to "/user"
    Then the response status code should be 200
    And the response content should be:
    """
    {
        "username": "abuenosvinos"
    }
    """