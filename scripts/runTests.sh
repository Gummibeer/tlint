#! /bin/bash

echo "Running tests in PHP7.1..."
docker run -v $PWD:/home/tightenco/ tightenco/tests-php7.1

echo "Running tests in PHP7.2..."
docker run -v $PWD:/home/tightenco/ tightenco/tests-php7.2

echo "Running tests in PHP-Nightly..."
docker run -v $PWD:/home/tightenco/ tightenco/tests-php-nightly
