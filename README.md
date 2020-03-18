# By Human Be Friendly

A clock that responds with a “human friendly” interpretation of the current time or a given time.

Credit to - https://www.geeksforgeeks.org/convert-given-time-words/ - for providing the logic for the clock.

## Dependencies

 - [Symfony Server](https://symfony.com/doc/current/setup/symfony_server.html)

## Setup

- `symfony composer install`

## Testing

- `./bin/phpunit`

## Command

- `symfony console app:human-friendly-time 12:00`

## API

- `https://localhost:8000/api/human-friendly-time?time=12:23`