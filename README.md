<h1 style="text-align: center;">Necromunda Campaign Tracker</h1>

<div align="center">
  <img src="https://img.shields.io/badge/PHP-8.1-blue" alt="PHP Version" />
  <img src="https://img.shields.io/badge/Symfony-6.4-purple" alt="Symfony" />
  <img src="https://img.shields.io/badge/Easy admin-4.12-green" alt="Easy admin" />
</div>

<div style="text-align: center;">
    <img src="https://raw.githubusercontent.com/BrunoMaucourt/Necromunda/main/public/img/Necromunda_campaign_tracker.png" alt="Necromunda Logo" width="200" />
</div>


## Introduction

Necromunda Campaign Tracker is a web application developed in PHP using the Symfony framework and the EasyAdmin bundle. It is designed to help players of Necromunda (Community Edition 2021) track their campaigns, manage their gangs, and record battle results.

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

- **Campaign tracking**: Create and manage campaigns with detailed statistics.
- **Gang management**: Track members, equipment, and the evolution of each gang.
- **Battle results**: Record battles with detailed reports.
- **Statistics reports**: Analyze campaign performance with graphs and summaries.

## Prerequisites

Before you begin, make sure you have the following installed on your machine:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)

## Installation

### Clone the repository

```bash
git clone https://github.com/your-username/necromunda-campaign-tracker.git
cd necromunda-campaign-tracker
```

Build the Docker image
From the root directory of the project, run the following command to start the Docker containers:

```bash
docker-compose up --build -d
```
Install dependencies
Once the Docker containers are up and running, access the PHP container and install the Composer dependencies:

```bash
docker-compose exec php-fpm
composer install
```
Configuration
.env.local file
Create a .env.local file at the root of the project for environment-specific variables and specify the database URL:

bash
Copy code
DATABASE_URL="mysql://user:password@127.0.0.1:3306/necromunda"
Database migration
Run migrations to create the necessary tables in the database:

bash
Copy code
php bin/console doctrine:migrations:migrate
Production deployment
When deploying this project to production, don’t forget to compile the asset map.

bash
Copy code
php bin/console asset-map:compile
Backup the database
This project uses the makinacorpus/db-tools-bundle package to automatically back up the database, ensuring the possibility of restoration in case of problems. To perform a manual backup, you can run the following command:

bash
Copy code
php bin/console db-tools:backup
To revert to a previous backup in case of issues, use the command:

bash
Copy code
php bin/console db-tools:restore
Usage
Access the application by opening your browser and visiting http://localhost:8000.

Admin
Granting admin status to a user allows them to access more menus and modify custom rules. To do this, add the role ["ROLE_ADMIN"] in the MySQL database for the user.

Custom rules
Custom rules have been added to the base game. These rules can be activated from the "Custom Rules" tab, accessible only to the site's admin.

Contributing
Contributions are welcome! Please follow these steps to contribute:

Fork this repository.
Create a branch for your feature:

bash
Copy code
git checkout -b feature/AmazingFeature
Commit your changes:

bash
Copy code
git commit -m 'Add some AmazingFeature'
Push your branch:

bash
Copy code
git push origin feature/AmazingFeature
Open a Pull Request.

License
This project is licensed under the GNU license. See the LICENSE file for more details.

Disclaimer
This project, Necromunda Campaign Tracker, is a personal and non-commercial project. It uses data and content from the Necromunda board game, created by Games Workshop. Necromunda and all associated trademarks and names are the property of Games Workshop.

This project is in no way affiliated, sponsored, or approved by Games Workshop. All data and content used in this project are the property of their respective owners and are used solely for non-commercial and educational purposes.