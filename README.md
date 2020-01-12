An example of a small REST application that implements user story:

"As a user, I want to have an ability to see a list of tasks for my day, so that I can do them one by one".

#### How to start:

```bash
docker-compose up -d --build
```

```bash
docker-compose exec -u $UID app composer install -o --no-cache
```

Go to [localhost:8080/api/1/task/list](http://localhost:8080/api/1/task/list)

#### How to run tests:

```bash
docker-compose exec -u $UID app vendor/bin/simple-phpunit
```

#### How to stop:

```bash
docker-compose down
```
