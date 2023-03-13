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

### Recognized Shortcomings
* The test cases don't cover 100% of the possible scenarios, e.g. the different combinations of missing body attributes, reasoning: time constraints.
* Test methods don't follow the PHP Laravel documenting convention, reasoning: I've determined this to be redundant since the test case method names themselves are self-explanatory and don't require further documentation, additionally they're not called by any users, so the documenting strings wouldn't be helpful to anyone either.
* In the tests for the `GET /worker/clock-ins` endpoint in the test case method: `test_the_application_returns_array_of_clock_ins_for_the_worker` the `type` seems not to be returned from the model creation, this should've been investigated and fixed, reasoning: time constraints.


Note: This list doesn't mention shortcomings that are inherently part of the requirements, e.g. worker registration and hard-coded coordinates.