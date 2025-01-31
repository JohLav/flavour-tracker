# Flavour-tracker

## Presentation

Flavour Tracker is a web application designed to revolutionize the way users discover restaurants, bars, and cafés by allowing them to search for specific dishes or beverages rather than just locations or types of cuisine. The project focuses on solving a common user frustration: the inability to find establishments based on specific dishes or beverages.

Initially focused on the Auvergne-Rhône-Alpes region, known for its culinary diversity, Flavour Tracker aims to serve as an indispensable tool for gastronomic exploration.

### Key Features

- **Search Bar Functionality**: Advanced text-based search allowing users to locate restaurants by specific dishes, beverages, or keywords.
- **Dish Type Filtering**: Dynamic filters enable users to narrow results based on cuisine types, dietary preferences, or meal categories (e.g., starters, main courses, desserts).
- **Menu and Dish Browsing**: Fetch and display complete menus, including dish details, descriptions, and prices, with optimized rendering for fast loading.
- **Reservation System: Integrated booking feature with credit card payment handling for securing reservations. Includes form validation and secure storage via industry-standard encryption.
- **User Profiles**:
  - *Restaurant Owners*: Manage menus, upload dishes with images, set availability, and respond to reservations.
  - *Clients*: Save favorite restaurants, track reservations, and leave reviews or ratings.

### Getting Started

This project used a starter kit designed for the Wild Code School's students to quickly set up a Symfony-based project. It includes a symfony/website-skeleton setup with additional tools for code validation and asset management.

Ensure the following are installed on your system:
- Composer
- Yarn & Node.js

### Installation

1. Clone this repository:
```bash
git clone https://github.com/JohLav/flavour-tracker.git
```

2. Install PHP & Javascript dependencies:
```bash
composer install
yarn install
```

3. Build assets
```bash
yarn encore dev
```

### Development workflow
1. Start the symfony server:
```bash
symfony server:start
```

2. Start the asset watcher or use Hot Module Reload:
```bash
yarn run dev --watch
yarn dev-server
```

### Code Quality and Testing

GrumPHP, as pre-commit hook, will run 2 tools when `git commit` is run :

- PHP_CodeSniffer to check PSR12
- PHPStan focuses on finding errors in your code (without actually running it)
- PHPmd will check if you follow PHP best practices

If tests fail, the commit is canceled and a warning message is displayed to developer.

GitHub Action as Continuous Integration will be run when a branch with active pull request is updated on gitHub. It will run :

- Tasks to check if vendor, .idea, env.local are not versioned,
- PHP_CodeSniffer, PHPStan and PHPmd with same configuration as GrumPHP.

#### Run the following commands to ensure code quality:

- PHP CodeSniffer:
```bash
php ./vendor/bin/phpcs
```
- PHPStan (maximum level):
```bash
composer exec phpstan analyse phpstan.neon
```
- PHP Mess Detector:
```bash
php ./vendor/bin/phpmd src text phpmd.xml
```
- ESLint for JavaScript:
```bash
./node_modules/.bin/eslint assets/js
```

### Windows-Specific Configuration

For Windows users, set Git's end-of-line rules:
```bash
git config --global core.autocrlf true
```

The `.editorconfig` file in the root directory enforces consistent formatting. Install the `EditorConfig` extension if you're using VSCode.

### Running Locally with Docker

1. Configure the database URL in `.env.local`:
```bash
DATABASE_URL="mysql://user:password@localhost:3306/<choose_a_db_name>"
```

2. Install Docker Desktop and run the command:
```bash
docker-compose up -d
```
3. Wait a moment and visit http://localhost:8000


## Deployment

The following files handle deployment automation (e.g., Caprover, Docker, GitHub Actions).

* [captain-definition](/captain-definition) Caprover entry point
* [Dockerfile](/Dockerfile) Web app configuration for Docker container
* [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
* [nginx.conf](/nginx.conf) Nginx server configuration
* [php.ini](/php.ini) Php configuration


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)
