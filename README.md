StudioManager
============================

Dear Reviewer,

The most important part of the application you can find in `/src` dir. I try to adopt Onion/Hexagonal Architecture here.
I'm aware that StudioManager is a very simple application and probably an app with such low complexity level do not need patterns like this.
I assume that it could be a frame to build a more complex application and I would like to show a concept.
`/src/StudioManager` should be treated as Business Logic layer - independent of a framework.
`/src/App` should be treated as most outer layer where `/src/App/Controllers` is Primary Adapters layer and `/src/App/Repository` is Secondary Adapters layer.

I appreciate any feedback.

Regards
Tomasz

============================
# System requirements

* PHP 7.1

### First run

Clone the app repository

```bash
git clone https://github.com/kaff/studiomanager.git
```

## with Docker & docker-compose 
(all command should be run in project root directory) 

Run in bash
```
docker-compose build
docker-compose up -d
docker-compose exec php bash -c "composer install"
docker-compose exec php bash -c "symfony serve -d"
```

The application should be accessible on http://127.0.0.1:8000/

to run all test
```
docker-compose exec php bash -c "bin/behat && bin/phpspec run && bin/phpunit"
```

##without Docker
Run in bash
```
composer install
symfony serve -d
```

The application should be accessible on http://127.0.0.1:8000/

to run all test
```
bin/behat && bin/phpspec run && bin/phpunit
```

###Make Request

##Example POST /api/classes request:

```
POST /api/classes HTTP/1.1
Host: 127.0.0.1:8000
Content-Type: application/json

{
  "name": "Pilates",
  "start_date": "2020-02-22",
  "end_date": "2020-02-24",
  "capacity": 10
}
```

##Example POST /api/bookings request:

```
POST /api/bookings HTTP/1.1
Host: 127.0.0.1:8000
Content-Type: application/json

{
  "member_name": "Tomasz paloc",
  "class_date": "2020-02-22"
}
```
