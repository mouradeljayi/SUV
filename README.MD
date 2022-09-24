# suv_norsys_afrique

## Initilisation d'environement
```
install docker
install docker-compose
install npm
install git
install php8.0
install composer
les extensions php requises: Ctype, iconv, PCRE, Session, SimpleXML, and Tokenizer
```

### Une fois le projet est cloné
```
cd projet_dir
docker-compose up -d
cd backend-suv_norsys_afrique
composer install
docker ps -a
```
### Copier l'id du container 'php-apache_suv_norsys_afrique' ou bien copier juste le nom 'php-apache-suv_norsys_afrique'

```
docker exec -it [coller l'id ici ou le nom] bash
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### La partie front-end
```
cd frontend-suv_norsys_afrique
npm install
npm run serve
```

### Integration d'authentification JWT
```
cd backend-suv_norsys_afrique
composer require lexik/jwt-authentication-bundle

mkdir config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
   - coller la phrase de passe (vous allez la trouvez dans le fichier .env)

openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
   - coller la phrase de passe (vous allez la trouvez dans le fichier .env)

sudo chmod -R 777 config/jwt

cd ..
php bin/console doctrine:schema:update --force
```

### Information supplémentaire
```
addresse du phpmyadmin: http://localhost:90/ , login: root, password: (vide)
addresse de la partie backend: http://localhost:98/
```

