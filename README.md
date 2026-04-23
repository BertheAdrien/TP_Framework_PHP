# CineMap - Gestion d'emplacements de tournage

Application Laravel de gestion d'emplacements de tournage de films avec authentification, autorisation par rôles, système d'upvotes, paiement Stripe, API JWT et intégration MCP.

## 📋 Table des matières

- [Installation](#installation)
- [Configuration](#configuration)
- [Lancement du projet](#lancement-du-projet)
- [Utilisateurs de test](#utilisateurs-de-test)
- [Fonctionnalités](#fonctionnalités)
- [API JWT](#api-jwt)
- [MCP (Model Context Protocol)](#mcp-model-context-protocol)
- [Commandes Artisan](#commandes-artisan)
- [Laravel Pint](#laravel-pint)

---

## 🚀 Installation

### 1. Cloner et installer les dépendances

```bash
# Cloner le projet (si applicable)
cd TPFramework

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Créer le fichier .env
cp .env.example .env

# Générer la clé de l'application
php artisan key:generate
```

### 2. Configurer la base de données

Le projet utilise SQLite par défaut. Assurez-vous que le fichier existe :

```bash
touch database/database.sqlite
```

### 3. Lancer les migrations et les seeders

```bash
php artisan migrate

# Optionnel : insérer les données de test (admin + utilisateur)
php artisan db:seed
```

---

## ⚙️ Configuration

### Configuration GitHub OAuth (Étape 7)

1. Créer une application OAuth sur GitHub : https://github.com/settings/developers
2. Définir l'URL de callback : `http://localhost:8000/auth/github/callback`
3. Ajouter dans le `.env` :

```env
GITHUB_CLIENT_ID=votre_client_id
GITHUB_CLIENT_SECRET=votre_client_secret
GITHUB_REDIRECT=http://localhost:8000/auth/github/callback
```

### Configuration Stripe (Étape 8)

1. Créer un compte Stripe : https://dashboard.stripe.com
2. Récupérer les clés API de test
3. Ajouter dans le `.env` :

```env
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
STRIPE_WEBHOOK_SECRET=whsec_votre_secret_webhook
```

**Carte de test Stripe :** `4242 4242 4242 4242`
- Date : n'importe quelle date future
- CVC : n'importe quel code à 3 chiffres

### Configuration JWT (Étape 8)

Générer la clé JWT :

```bash
php artisan jwt:secret
```

---

## ▶️ Lancement du projet

### Lancer le serveur web

```bash
php artisan serve
```

L'application est accessible sur http://localhost:8000

### Lancer le worker de queue (Étape 4)

Dans un nouveau terminal :

```bash
php artisan queue:work
```

**Important :** Le worker doit tourner pour traiter les jobs d'upvotes.

### Lancer le planning des tâches (Étape 5)

Pour tester la commande planifiée manuellement :

```bash
# Tester la commande
php artisan locations:clean

# Voir les tâches planifiées
php artisan schedule:list
```

Pour la production, ajouter cette cron job :

```bash
* * * * * cd /chemin/vers/projet && php artisan schedule:run >> /dev/null 2>&1
```

---

## 👥 Utilisateurs de test

Après avoir lancé les seeders (`php artisan db:seed`) :

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Administrateur** | admin@example.com | password |
| **Utilisateur** | user@example.com | password |

---

## ✨ Fonctionnalités

### Étape 1 - Authentification
- Inscription / Connexion / Déconnexion
- Authentification via GitHub OAuth

### Étape 2 - CRUDs métier
- **Films** : Liste, détail, création, modification, suppression (admin uniquement)
- **Locations** : Liste, création, modification, suppression (propriétaire ou admin)

### Étape 3 - Middleware administrateur
- Middleware `is_admin` pour protéger les routes admin
- Middleware `location.owner` pour vérifier la propriété des locations
- Règles :
  - Admin : accès complet à tous les films et locations
  - Utilisateur : consultation films, CRUD sur ses propres locations uniquement

### Étape 4 - Queues et Jobs
- **Job** : `RecalculateUpvotes` - recalcule le compteur d'upvotes
- Dispatché lorsqu'un utilisateur upvote une location
- **Route** : `POST /locations/{location}/upvote`

### Étape 5 - Commande Artisan + Tâche planifiée
- **Commande** : `php artisan locations:clean`
- Supprime les locations de plus de 14 jours avec moins de 2 upvotes
- Planifiée quotidiennement dans `routes/console.php`

### Étape 6 - Laravel Pint
```bash
# Vérifier le formatage
./vendor/bin/pint --test

# Formater le code
./vendor/bin/pint
```

### Étape 7 - Connexion OAuth (GitHub)
- Bouton "Connexion avec GitHub" sur la page de login
- Création automatique du compte si inexistant

### Étape 8 - Abonnement Stripe + API JWT
- **Page d'abonnement** : `/subscribe`
- **Paiement** : 5€ via Stripe Checkout
- **Badge** : Indicateur "Abonné/Non abonné" dans la navigation
- **API protégée** : `/api/films/{film}/locations` (JWT + abonnement requis)

### Étape 9 - MCP (Model Context Protocol)
- **Outils disponibles** :
  - `list_films` : Liste tous les films
  - `get_locations_for_film` : Récupère les emplacements d'un film
- **Fichier** : `mcp/server.js`
- **Configuration** : voir section [MCP](#mcp-model-context-protocol)

---

## 🔐 API JWT

### Générer un token JWT

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'
```

### Appeler l'API protégée

```bash
curl -X GET http://localhost:8000/api/films/1/locations \
  -H "Authorization: Bearer VOTRE_TOKEN_JWT"
```

### Réponse attendue

```json
{
  "film": {
    "id": 1,
    "title": "Inception"
  },
  "locations": [
    {
      "id": 1,
      "name": "Paris - Tour Eiffel",
      "city": "Paris",
      "country": "France"
    }
  ]
}
```

### Page de test

Une page de test est disponible sur `/test-api` (nécessite d'être connecté).

---

## 🤖 MCP (Model Context Protocol)

### Installation

```bash
cd mcp
npm install
```

### Lancer le serveur MCP

```bash
node server.js
```

### Outils MCP disponibles

| Outil | Description | Paramètres |
|-------|-------------|------------|
| `list_films` | Liste tous les films | Aucun |
| `get_locations_for_film` | Récupère les emplacements d'un film | `film_id` (number) |

### Configuration avec Claude Desktop

Ajouter dans `claude_desktop_config.json` :

```json
{
  "mcpServers": {
    "cinemap": {
      "command": "node",
      "args": ["/chemin/vers/TPFramework/mcp/server.js"]
    }
  }
}
```

---

## 📁 Structure du projet

```
TPFramework/
├── app/
│   ├── Console/Commands/CleanOldLocations.php  # Commande planifiée
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── FilmController.php
│   │   │   └── LocationController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php             # Middleware admin
│   │       ├── CheckLocationOwnerOrAdmin.php   # Middleware propriétaire
│   │       └── EnsureSubscribed.php            # Middleware abonnement
│   ├── Jobs/RecalculateUpvotes.php             # Job upvotes
│   └── Models/
│       ├── Film.php
│       ├── Location.php
│       ├── Upvote.php
│       └── User.php
├── config/
│   ├── auth.php                               # Guard JWT
│   └── services.php                           # Config Stripe/GitHub
├── database/
│   ├── migrations/                            # Toutes les migrations
│   └── seeders/UserSeeder.php                 # Users de test
├── mcp/
│   ├── package.json
│   └── server.js                              # Serveur MCP
├── routes/
│   ├── api.php                                # Routes API JWT
│   ├── console.php                            # Schedule commande
│   └── web.php                                # Routes web
└── resources/views/                           # Vues Blade
```

---

## 🛠️ Commandes Artisan utiles

```bash
# Liste des commandes personnalisées
php artisan list

# Tester la commande de nettoyage
php artisan locations:clean

# Voir les tâches planifiées
php artisan schedule:list

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Recharger les migrations
php artisan migrate:fresh --seed
```

---

## 📦 Dépendances principales

| Package | Version | Usage |
|---------|---------|-------|
| `laravel/framework` | ^13.0 | Framework Laravel |
| `laravel/breeze` | ^2.4 | Authentification starter kit |
| `laravel/socialite` | ^5.26 | OAuth GitHub |
| `stripe/stripe-php` | ^20.0 | Paiements Stripe |
| `php-open-source-saver/jwt-auth` | ^2.9 | Authentification JWT |
| `laravel/pint` | ^1.29 | Linter PHP |

---

## 📝 Notes importantes

1. **Queue** : N'oubliez pas de lancer `php artisan queue:work` pour traiter les jobs
2. **Stripe** : Utilisez les cartes de test fournies par Stripe
3. **JWT** : Le token expire après un certain temps, régénérez-le si nécessaire
4. **MCP** : Le serveur MCP doit être redémarré après chaque modification du code

---

## 🎓 Objectifs pédagogiques couverts

- ✅ Authentification Laravel (Breeze)
- ✅ CRUDs standards (Films + Locations)
- ✅ Middleware personnalisé (Admin + Propriétaire)
- ✅ Queues et Jobs (RecalculateUpvotes)
- ✅ Commande Artisan personnalisée + planification (CleanOldLocations)
- ✅ Laravel Pint
- ✅ Connexion OAuth via GitHub
- ✅ API JSON protégée par JWT + abonnement Stripe
- ✅ Intégration MCP simple

---

**Projet réalisé dans le cadre d'un TP Framework PHP - Laravel**
