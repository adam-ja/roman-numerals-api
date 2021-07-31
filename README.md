# Solution

## Instructions

- I've added Laravel Sail to provide a database regardless of your local setup. You will need Docker and Docker Compose installed, but you probably already have them anyway.
- Install composer dependencies with `composer install`.
- Copy `.env.example` to `.env` (Note: I've added some default database env values to the example just to make it easy to copy the file and get running. Obviously anything sensitive or environment specific wouldn't normally be committed).
- Run the Laravel Sail docker environment with `vendor/bin/sail up` (add `-d` to run detached).
- Apply the database migration to create the integer conversion table: `vendor/bin/sail artisan migrate`.
- Run tests with `vendor/bin/sail test`.
- Test the conversion endpoint with a POST of the following JSON to http://localhost/api/integer-conversion/convert (accepts any integer between 1 and 3999):
```json
{
    "integer": 10
}
```
- Test the latest conversions endpoint with a GET request to http://localhost/api/integer-conversion/latest (defaults to top 10 - optionally add `?limit=n` where n > 0).
- Test the most popular conversions endpoint with a GET request to http://localhost/api/integer-conversion/most-popular (defaults to top 10 - optionally add `?limit=n` where n > 0).

## Notes

- In the `IntegerConversionController::convert()` action you will see that I did not use the `firstOrCreate` method. I could have done this:
```php
$conversion = IntegerConversion::firstOrCreate(
    ['integer_value' => $integer],
    ['converted_value' => $converter->convertInteger($integer)]
);
```
However, this solution would result in the converter being called every time, even if we had previously done and stored the conversion for the requested integer value. With my implementation, the conversion is only done when it is needed for a new value. Obviously, with this simple example, the conversion isn't exactly expensive but I thought I would show that I consider such things.
- The EnforceJson middleware ensures Laravel always returns JSON responses (e.g. when validation fails) even if the client forgets to set the Accept header. A useful trick for JSON APIs, shamelessly stolen from [here](https://twitter.com/TheAlexLichter/status/969879256271597568).
- I haven't used Laravel API Resources before and wasn't sure the best way to test them in my feature tests, nor could I find any real consensus on the topic. I wanted to include some coverage but I'm keen to only test the code we write and not the framework itself. I'd be happy to discuss and learn alternative approaches to this.

# Roman Numerals API Task

This development task is based on the Roman Numeral code kata which may have already been completed during this recruitment process. This task requires you to build a JSON API and so any HTML, CSS or JavaScript that is submitted will not be reviewed.

## Brief
Our client (Numeral McNumberFace) requires a simple RESTful API which will convert an integer to its roman numeral counterpart. After our discussions with the client, we have discovered that the solution will contain three API endpoints, and will only support integers ranging from 1 to 3999. The client wishes to keep track of conversions so they can determine which is the most frequently converted integer, and the last time this was converted.

### Endpoints Required
 1. Accepts an integer, converts it to a roman numeral, stores it in the database and returns the response.
 2. Lists all the recently converted integers.
 3. Lists the top 10 converted integers.

## What we are looking for
 - Use of MVC components (View in this instance can be, for example, a Laravel Resource).
 - Use of [Fractal](https://fractal.thephpleague.com/) or [Laravel Resources](https://laravel.com/docs/8.x/eloquent-resources)
 - Use of Laravel features such as Eloquent, Requests, Validation and Routes.
 - An implementation of the supplied interface.
 - The supplied PHPUnit test passing.
 - Clean code, following PSR-12 standards.
 - Use of PHP 7.4 features where appropriate.

## Submission Instructions
Please create a [git bundle](https://git-scm.com/docs/git-bundle/) and send the file across:
```
git bundle create <yourname>.bundle --all --branches
```
