# PHP
Use: php 7.4.11+
Symfony 5.1.8

# Note

This is a personal exercise based on Fabien Potencier book "The Fast Track". Some codes may vary because i was reading the book on 2020 and it is originally from 2019

# Installation

1. Clone the repository and cd that location
2. symfony server:ca:install - install a CA
3. symfony book:check-requirements - to allow you to install some packages
4. symfony new guestbook --version=5.1.* - to create a new project but if you cloned the repository this is not necessary
5. symfony server:start -d - to start server, maybe at this point it won't work because you will need a data base
6. symfony project:init - to add SymfonyCloud Support
7. symfony project:create --title="Guestbook" --plan=development - Login on SymfonyCloud and create a project
8. symfony deploy - deploy on symfony cloud
9. symfony open:remote - to check symfony cloud installation
10. symfony open:local - to check local installation
11. symfony composer req profiler --dev - Install profiler onlly available y development mode
12. symfony composer req debug --dev
13. symfony composer req maker --dev
14. symfony composer req logger - this is added is here just to remind me
15. symfony composer req annotations - this is added is here just to remind me
16. symfony console make:controller ConferenceController  - this is added is here just to remind me, this controller is already created
17. docker-compose up -d - this will create a postgres DB in docker with the dockr-compose.yaml 
18. docker-compose ps - to check the docker state
19. symfony run psql - to access postgres
19.1 docker exec -it guestbook_database_1 psql -U main -W main
20. .symfony/services.yaml - necessary file to symfony cloud and docker
21 .symfony.cloud.yaml - necessary file to symfony cloud and docker
22. symfony tunnel:open --expose-env-vars - expose the symfony cloud environment
22.1 symfony run psql - when env is exposed you can connect to symfony cloud psql
22.2 symfony tunnel:close 
23. symfony var:export - verify env variables
24. symfony composer req orm - install doctrine - this is here only to remind me
25. Edit .env to add postgress, somethin like "DATABASE_URL=postgresql://127.0.0.1:5432/db?serverVersion=11&charset=utf8"
26. symfony console make:entity Conference - Create your entities - this is only to remind me
27. symfony console make:entity Conference - Create relationship on "Field Type Step" OneToMany or ManyToOne or others once your entities are created
28. symfony console make:migration - create the script for DB
29. symfony console doctrine:migrations:migrate - update the DB
30. symfony composer req admin - install a backed module
31. symfony composer req twig - install twig
32. symfony composer require twig/intl-extra
33. git checkout -b sessions-in-redis - create a new branch per new feature or resolved bug




