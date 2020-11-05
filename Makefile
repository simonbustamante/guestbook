SHELL := /bin/bash

tests:
	symfony console doctrine:fixtures:load -n
	symfony run bin/phpunit tests/Controller/ConferenceControllerTest.php
.PHONY: tests