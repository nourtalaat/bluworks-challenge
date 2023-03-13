## Bluworks Challenge
This project serves as an answer to the technical assessment as requested by Bluworks.

### Problem Statement
We needed to implement two endpoints that enable logging a clock-in and fetching the clock-ins for a given worker:
* `POST /worker/clock-in`
* `GET /worker/clock-ins`

This also included performing the following steps:
* Creating the relevant database models w/ the appropriate migrations.
* Having a rudimentary file structure with clearly defined responsibilities for each type of module, e.g. controllers and services.
* Crafting test cases, i.e. Postman collection w/ examples, and implementing them in a suitable way, e.g. integration tests.
* Documenting this piece of software, i.e. this README, Swagger, and the Postman collection.

### Getting Started
* In the `getting_started` directory in the root of this repository you'll find two files:
  * `bluworks_mysql_test_dump.sql`: MySQL database dump to be used for testing purposes.
  * `bluworks-challenge.postman_collection.json`: Postman collection export to be used for testing/documentation purposes.
* After importing the database dump you could start the Laravel server: `php artisan serve` and test with either [Swagger](http://localhost:8000/api/docs) or the Postman collection.
* For the automated tests I've crafted a number of integrations tests to help demonstrate what a more complete version could look like, you could run these tests with: `php artisan test`.

### Design Decisions
* Test cases: I've utilized only integration tests instead of a combination of integration and unit tests due to both the simplicity of the task flows and the inadequacy of the unit tests had they been implemented, e.g. due to having `private` methods we'd have had to combine the logic of these methods with their callers.
* Error response messages: With the exception of the resource not found and the max vicinity distance errors (Which was done to help clients present helpful messages) I've decided to keep the messages intentionally vague to give possible malicious actors a harder time reverse engineering the validation checks.

### Recognized Shortcomings
* The test cases don't cover 100% of the possible scenarios, e.g. the different combinations of missing body attributes, reasoning: time constraints.
* Test methods don't follow the PHP Laravel documenting convention, reasoning: I've determined this to be redundant since the test case method names themselves are self-explanatory and don't require further documentation, additionally they're not called by any users, so the documenting strings wouldn't be helpful to anyone either.
* In the tests for the `GET /worker/clock-ins` endpoint in the test case method: `test_the_application_returns_array_of_clock_ins_for_the_worker` the `type` seems not to be returned from the model creation, this should've been investigated and fixed, reasoning: time constraints.


Note: This list doesn't mention shortcomings that are inherently part of the requirements, e.g. worker registration and hard-coded coordinates.

### Possible Areas of Improvement
* Authenticating the requests.
* Ensuring data integrity, because as it stands currently the data sent by the client has to pass a number of basic checks, but we don't validate the authenticity of the data provided, e.g. timestamp or the coordinates, possible improvements:
  * Calculating the `timestamp` on the server-side instead of receiving it from the client-side.
  * Implementing guarantees to ensure that the coordinates are retrieved directly from the GPS sensor and are not arbitrary, I'm not exactly sure about how such a measure could be implemented, but even if done this would present it's own set of challenges, including dealing with GPS spoofing.
* Using error codes instead of error messages, this could make it easier for the clients to understand the nature of the error (If we'd like to disclose it) without making it readily accessible to a malicious actor.

### Used References
* [Distance calculation](https://www.geodatasource.com/developers/php)

Note: Obviously more references were used, but this is the only case where a direct copy/paste of code was done, so I felt it was noteworthy.