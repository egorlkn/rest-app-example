#### How to start:

```bash
docker-compose up -d --build
```

```bash
docker-compose exec -u $UID app composer install -o --no-cache
```

Go to [localhost:8080](http://localhost:8080/)

#### How to run tests:

```bash
docker-compose exec -u $UID app vendor/bin/simple-phpunit
```

#### How to stop:

```bash
docker-compose down
```
