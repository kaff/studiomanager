Feature:
  In order to attend classes
  As a member of a studio
  I want to have a possibility to book for a class

  Scenario: Can book for a class
    Given there is class for "2020-02-11" with name "Karate"
    And the request body is:
    """
    {
      "member_name": "Grzegorz Brzęczyszczykiewicz",
      "class_date": "2020-02-11"
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
    Then the response code is 201
    And the "Location" response header matches "/\/api\/bookings\/[a-f0-9]{32}/"
    And the response body matches:
    """
    /\"booking_uid\": \"[a-f0-9]{32}\"/
    """
    And the response body contains JSON:
    """
    {
      "member_name": "Grzegorz Brzęczyszczykiewicz",
      "class_date": "2020-02-11",
      "class_name": "Karate"
    }
    """

  Scenario: Receive a error message when try book for non-existent class
    Given the request body is:
    """
    {
      "member_name": "Grzegorz Brzęczyszczykiewicz",
      "class_date": "2020-02-11"
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
    {
      "code": 400,
      "message": "There is not any class for given date."
    }
    """

  Scenario: Receive a error message when request format is invalid
    Given the request body is:
    """
    {
      "name": "Karate
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
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
      "member_name": "",
      "class_date": ""
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
    {
       "code": 400,
       "error": "Validation error",
       "messages": {
           "memberName": "This value should not be blank.",
           "classDate": "This value should not be blank."
       }
    }
    """

  Scenario: Receive an error message when name is longer than 255 characters
    Given the request body is:
    """
    {
      "member_name": "A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name A very long name",
      "class_date": "2020-01-02"
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
              "memberName": "This value is too long. It should have 255 characters or less."
          }
      }
    """

  Scenario: Receive an error message when date is invalid
    Given the request body is:
    """
    {
      "member_name": "Grzegorz Brzęczyszczykiewicz",
      "class_date": "2020-0102"
    }
    """
    And the "Content-Type" request header is "application/json"
    When I request "api/bookings" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
            "classDate": "This value is not a valid date. Correct format: YYYY-MM-DD"
          }
      }
    """
