Feature: Home
  In order to know if the system is working
  As a product owner
  I want to check if the home is loading

  Scenario: Check if the home is working
    Given I have a browser prepared
    And I send a GET request to "/"
    Then the response status code should be 200
    And the response content should has "Listado de Cursos":
