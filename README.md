# Necromunda Campaign Tracker


<img src="https://raw.githubusercontent.com/BrunoMaucourt/Necromunda/main/public/img/Necromunda_campaign_tracker.png" alt="Necromunda Logo" width="200" />


## Introduction


Necromunda Campaign Tracker is a web application developed in PHP with the Symfony framework and the EasyAdmin bundle. It is designed to help Necromunda (Community Edition 2021) players track their campaigns, manage their gangs, and record battle results.


## Table of Contents


- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Disclaimer](#disclaimer)


## Features


- Campaign and battle tracking
- Gang management
- Battle result recording
- Campaign statistics and reports


## Prerequisites


Before starting, make sure you have the following installed on your machine:


- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)


## Installation


### Clone the repository


```bash
git clone https://github.com/your-username/necromunda-campaign-tracker.git
cd necromunda-campaign-tracker
```


#### Build the Docker image


Make sure you are in the root directory of the project, then run:


```bash
docker-compose up --build -d
```


### Install dependencies


Once the Docker containers are running, access the PHP container and install the Composer dependencies:


``` bash
docker-compose exec php-fpm bash
composer install
```


## Configuration


### .env.local file


Create a .env.local file at the root of the project for installation-specific variables and specify the database URL:


``` bash
DATABASE_URL="mysql://user:password@127.0.0.1:3306/necromunda"
```


### Database migration


Run the migrations to create the necessary tables in the database:


```bash
php bin/console doctrine:migrations:migrate
```


## Usage


Access the application by opening your browser and visiting http://localhost:8000.


## Contributing


Contributions are welcome! Please follow these steps to contribute:


### Fork this repository.


Create a branch for your feature:


``` bash
git checkout -b feature/AmazingFeature.
```


Commit your changes:


```bash
git commit -m 'Add some AmazingFeature'
```


Push your branch:


``` bash
git push origin feature/AmazingFeature
```


Open a Pull Request.

## License


This project is licensed under the GNU license. See the LICENSE file for details.


## Disclaimer


This project, Necromunda Campaign Tracker, is a personal and non-commercial project. It uses data and content from the board game Necromunda, created by Games Workshop. Necromunda and all associated trademarks and names are the property of Games Workshop.


This project is not affiliated, sponsored, or endorsed by Games Workshop. All data and content used in this project are the property of their respective owners and are used solely for non-commercial and educational purposes.


# Necromunda Campaign Tracker


<img src="https://raw.githubusercontent.com/BrunoMaucourt/Necromunda/main/public/img/Necromunda_campaign_tracker.png" alt="Necromunda Logo" width="200" />


## Introduction


Necromunda Campaign Tracker est une application web développée en PHP avec le framework Symfony et le bundle EasyAdmin. Elle est conçue pour aider les joueurs de Necromunda (Community Edition 2021) à suivre leurs campagnes, gérer leurs gangs, et enregistrer les résultats des batailles.


## Table des matières


- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Contribuer](#contribuer)
- [Licence](#licence)
- [Avertissement](#avertissement)


## Fonctionnalités


- Suivi des campagnes et des batailles
- Gestion des gangs
- Enregistrement des résultats de bataille
- Statistiques et rapports de campagne


## Prérequis


Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)


## Installation


### Cloner le dépôt


```bash
git clone https://github.com/votre-utilisateur/necromunda-campaign-tracker.git
cd necromunda-campaign-tracker
```


### Construire l'image Docker


Assurez-vous que vous êtes dans le répertoire racine du projet, puis exécutez :


```bash
docker-compose up --build -d
```


### Installer les dépendances


Une fois les conteneurs Docker en cours d'exécution, accédez au conteneur PHP et installez les dépendances Composer :


``` bash
docker-compose exec php-fpm bash
composer install
```


## Configuration


### Fichier .env.local


Créez un fichier .env.local à la racine du projet pour les variables spécifiques à l'installation et spécifiez l'URL de la base de données :


``` bash
DATABASE_URL="mysql://user:password@127.0.0.1:3306/necromunda"
```


### Migration de la base de données


Exécutez les migrations pour créer les tables nécessaires dans la base de données :


``` bash
php bin/console doctrine:migrations:migrate
```


## Utilisation


Accédez à l'application en ouvrant votre navigateur et en visitant http://localhost:8000.

## Contribuer


Les contributions sont les bienvenues ! Veuillez suivre les étapes suivantes pour contribuer :


### Fork ce dépôt.


Créez une branche pour votre fonctionnalité :


``` bash
git checkout -b feature/AmazingFeature.
```


Commitez vos modifications :


``` bash
git commit -m 'Add some AmazingFeature'
```


Poussez votre branche :


``` bash
git push origin feature/AmazingFeature
```


Ouvrez une Pull Request.


## Licence


Ce projet est sous licence GNU. Voir le fichier LICENSE pour plus de détails.


## Avertissement


Ce projet, Necromunda Campaign Tracker, est un projet personnel et non commercial. Il utilise des données et du contenu issus du jeu de société Necromunda, créé par Games Workshop. Necromunda et toutes les marques et noms associés sont la propriété de Games Workshop.


Ce projet n'est en aucun cas affilié, sponsorisé ou approuvé par Games Workshop. Toutes les données et contenus utilisés dans ce projet sont la propriété de leurs propriétaires respectifs et sont utilisés uniquement à des fins non commerciales et éducatives.