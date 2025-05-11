# Getting Started

# First build and run the docker container:
docker-compose up

# Now run the composer with the help of docker:
docker exec democsvemployee-app-1 composer install

# run the tests:
docker exec democsvemployee-app-1 vendor/bin/phpunit tests

# launch in browser:
http://localhost:8080/

## add data to "CSV" database:
Just edit the [database.csv](src/database.csv)