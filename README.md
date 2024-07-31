# Mon Projet E-commerce Laravel

## Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :
- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [Node.js et npm](https://nodejs.org/en/download/)

## Installation

1. Clonez le dépôt sur votre machine locale :

    ```bash
    git clone https://github.com/AyoubKHE/Ecommerce.git
    cd votre-projet
    ```

2. Installez les dépendances PHP avec Composer :

    ```bash
    composer install
    ```

3. Installez les dépendances JavaScript avec npm :

    ```bash
    npm install
    ```

## Configuration

1. Copiez le fichier `.env.example` en `.env` et configurez vos paramètres d'environnement :

    ```bash
    cp .env.example .env
    ```

2. Générez la clé de l'application :

    ```bash
    php artisan key:generate
    ```

3. Configurez les paramètres de la base de données dans le fichier `.env` :

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nom_de_votre_base_de_donnees
    DB_USERNAME=votre_nom_utilisateur
    DB_PASSWORD=votre_mot_de_passe
    ```

## Exécution des Migrations

1. Exécutez les migrations pour créer les tables dans votre base de données :

    ```bash
    php artisan migrate
    ```

## Accès au Dashboard

1. Pour accéder au dashboard administrateur, vous devez créer un utilisateur manuellement dans la table `users` via phpMyAdmin ou un autre outil de gestion de base de données. Voici un exemple de commande SQL pour ajouter un utilisateur :

    ```sql
    INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`)
    VALUES ('Admin', 'admin@example.com', 'votre_mot_de_passe_hashé', NOW(), NOW());
    ```

   **Note:** Utilisez une fonction de hachage comme `bcrypt` pour sécuriser le mot de passe.
   
## Schéma Relationnel de la Base de Données

Vous trouverez le schéma relationnel de la base de données dans le dossier `database`. Ce schéma vous donnera une vue d'ensemble de la structure de la base de données et des relations entre les différentes tables.

## Lancement de l'Application

1. Démarrez le serveur de développement :

    ```bash
    php artisan serve
    ```

2. Accédez à votre application dans votre navigateur :

    ```
    http://localhost:8000
    ```

3. Connectez-vous au dashboard via :

    ```
    http://localhost:8000/admin
    ```

4. Utilisez les informations d'identification que vous avez créées pour vous connecter.

## Autres Informations

Pour plus d'informations sur l'utilisation de Laravel, consultez la [documentation officielle](https://laravel.com/docs).


