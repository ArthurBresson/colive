# SAE 3.01

## Auteurs

- Ruddy Gobillard
- Khalil El Kadiri
- Arthur Bresson
- Nathan Duport
- Khalil Moughamir

## Installation / Configuration

### Installation par `Composer`

Lancer `composer install` pour installer [PHP Coding Standards Fixer](https://cs.symfony.com/) et le configurer dans PhpStorm (le fichier `.php-cs-fixer.php` contient les règles personnalisées basées sur la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html))

### Configurer PhpStorm

Configurer l'intégration de PHP Coding Standards Fixer dans PhpStorm en fixant le jeu de règles sur `Custom` et en désignant `.php-cs-fixer.php` comme fichier de configuration de règles de codage.

## Serveur Web VM de l'IUT

Lancez le VPN de l'IUT ou allez sur une machine de l'IUT et rentrez `http://10.31.33.92:8000/accueil`

## Serveur Web local

### Lancement du serveur Web

Lancez le serveur Web local avec cette commande :
```bash
composer start
```

### Accès au serveur Web

Naviguez alors à partir de cette adresse : <https://127.0.0.1:8000/>


## Style de codage

Le script de vérification de code est exécuté via
```bash
composer test
```

Le script de reformatage de code est exécuté via
```bash
composer fix
```

Les scripts de test de code individuel sont exécuté via
```bash
composer test:phpcs

composer test:twigcs
```

Les scripts de fix de code individuel sont exécuté via
```bash
composer fix:phpcs

composer fix:twigcs
```

Le script pour faire une migration de la base de donnée est exécuté via
```bash
composer db:migrate
```

## Accès à la BDD

Copiez ".env" en ".env.local"

Et modifiez la ligne 34, en remplacant les infos par votre login et mot de passe :
```bash
DATABASE_URL="mysql://LOGIN:MOTDEPASSE@mysql:3306/LOGIN_BDD?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```

Lors de l'exécution des scripts de test, vous devrez également définir le fichier ".env.test.local".
Copiez le fichier ".env.test" en ".env.test.local", puis ajoutez la même ligne que celle définie au-dessus,
en utilisant un nom de base de données différent, afin de conserver votre BDD.

```bash
DATABASE_URL="mysql://LOGIN:MOTDEPASSE@mysql:3306/LOGIN_BDD?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```

## Compte tests

Vous pouvez vous connecter avec un compte utilisateur lambda, et un compte utilisateur admin.

Pour le rôle admin :
```bash
email : root@example.com
password : test
```

Pour le rôle utilisateur :
```bash
email : user@example.com
password : test
```
