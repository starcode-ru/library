Feature: Test API
  Scenario: Show me author list
    Given I set header "X-Auth-Token" with value "secure_key"
    When I send a GET request to "app_test.php/api/v1/authors"
    Then response code should be 200

  Scenario: Add new author to library
    Given I set header "X-Auth-Token" with value "secure_key"
    When I send a POST request to "app_test.php/api/v1/authors" with body:
      """
      {"author": {"name": "Author", "birthday": "1930-05-15"} }
      """
    Then response code should be 200
