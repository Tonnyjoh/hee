# Projet Laravel 10 - Gestion des Articles

## Description
Ce projet Laravel 10 implémente un système de gestion d'articles avec une API REST complète. Il respecte les bonnes pratiques de développement Laravel et propose une pagination efficace.

## Prérequis
- PHP 8.1 ou supérieur
- Composer
- MySQL 8.0+ ou PostgreSQL 13+

## Installation

### 1. Cloner le projet
```bash
cd gestion_article
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configuration de la base de données
Modifiez le fichier `.env` avec vos paramètres de base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_articles
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migration et seeding
```bash
php artisan migrate
php artisan db:seed --class=ArticleSeeder
```

### 6. Lancer le serveur de développement
```bash
php artisan serve
```

Le projet sera accessible à l'adresse : `http://localhost:8000`

## Utilisation de l'API

### Endpoint principal (selon le test)
```
GET /api/articles
```

### Endpoints complets
- `GET /api/v1/articles` - Liste paginée des articles
- `GET /api/v1/articles/{slug}` - Détail d'un article
- `POST /api/v1/articles` - Créer un article
- `PUT /api/v1/articles/{id}` - Modifier un article
- `DELETE /api/v1/articles/{id}` - Supprimer un article

### Paramètres de pagination
- `per_page` : Nombre d'éléments par page (défaut: 15, max: 50)
- `page` : Numéro de page

### Exemples d'utilisation

#### Récupérer tous les articles (première page)
```bash
curl -X GET "http://localhost:8000/api/articles"
```

#### Récupérer les articles avec pagination personnalisée
```bash
curl -X GET "http://localhost:8000/articles?per_page=10&page=2"
```

#### Créer un nouvel article
```bash
curl -X POST "http://localhost:8000/api/v1/articles" \
  -H "Content-Type: application/json" \
  -d '{
    "titre": "Mon nouvel article",
    "contenu": "Contenu de l'\''article...",
    "auteur": "John Doe",
    "date_publication": "2024-06-02T10:00:00Z"
  }'
```

## Structure du projet

### Modèles
- `App\Models\Article` : Modèle Eloquent avec relations et scopes

### Contrôleurs
- `App\Http\Controllers\ArticleController` : Gestion CRUD des articles

### Requests
- `App\Http\Requests\ArticleRequest` : Validation des données d'entrée

### Migrations
- `database/migrations/create_articles_table.php` : Structure de la table articles

### Seeders
- `database/seeders/ArticleSeeder.php` : Données de test

## Performance

### Optimisations implémentées
- **Index sur les colonnes** fréquemment utilisées
- **Pagination efficace** pour éviter le chargement de tous les articles
- **Limite de pagination** pour éviter les requêtes trop coûteuses
- **Scopes Eloquent** pour des requêtes réutilisables

## Débogage

### Logs
Les erreurs sont automatiquement loggées dans `storage/logs/laravel.log`

### Mode debug
En mode debug (`APP_DEBUG=true`), les erreurs détaillées sont retournées dans les réponses JSON.

