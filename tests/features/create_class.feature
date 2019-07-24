Feature:
  In order to studio's members can attend classes
  As a owner of a studio
  I want to have a possibility to create a class

  Scenario: Can create single class
    Given the request body is:
    """
    {
      "name": "Pilates",
      "start_date": "2020-02-11",
      "end_date": "2020-02-21",
      "capacity": 10
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/classes" using HTTP POST
    Then the response code is 201
    And the "Location" response header matches "/\/api\/classes\/[a-f0-9]{32}/"
    Then the response body matches:
    """
    /\"uid\": \"[a-f0-9]{32}\"/
    """
    And the response body contains JSON:
    """
    {
      "name": "Pilates",
      "start_date": "2020-02-11",
      "end_date": "2020-02-21",
      "capacity": 10
    }
    """

  Scenario: Receive a error message when request format is invalid
    Given the request body is:
    """
    {
      "name": "Pilates
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
    {
      "code": 400,
      "message": "Invalid json message received"
    }
    """

  Scenario: Receive an error message when there is a lack of required data
    Given the request body is:
    """
    {
      "name": "",
      "start_date": "",
      "end_date": "",
      "capacity": null
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
              "name": "This value should not be blank.",
              "startDate": "This value should not be blank.",
              "endDate": "This value should not be blank.",
              "capacity": "This value should not be blank."
          }
      }
    """

  Scenario: Receive an error message when name is longer than 255 characters
    Given the request body is:
    """
    {
      "name": "A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class ",
      "start_date": "2020-01-02",
      "end_date": "2020-01-02",
      "capacity": 10
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
              "name": "This value is too long. It should have 255 characters or less."
          }
      }
    """

  Scenario: Receive an error message when dates are invalid
    Given the request body is:
    """
    {
      "name": "Pilates",
      "start_date": "2020-0102",
      "end_date": "01-02-2020",
      "capacity": 10
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
            "startDate": "This value is not a valid date. Correct format: YYYY-MM-DD",
            "endDate": "This value is not a valid date. Correct format: YYYY-MM-DD"
          }
      }
    """
