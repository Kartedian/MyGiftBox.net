# MyGiftBox

MyGiftBox est une application web permettant de consulter un catalogue de prestations et de composer des coffrets cadeaux (boxes) personnalisés.

## Architecture et Technologies

Ce projet est construit sur une base PHP moderne et respecte les principes de la **Clean Architecture** (séparation en couches : domaine / application / infrastructure / webui).

* **Framework Routeur/Middleware :** Slim 4
* **Moteur de templates :** Twig
* **ORM (Base de données) :** Eloquent (Laravel)
* **Déploiement :** Docker / Docker Compose

---

## Fonctionnalités et Routes

L'application est divisée en plusieurs grands domaines fonctionnels, accessibles via l'interface web (rendu Twig) ou via une API REST (format JSON).

### 1. Catalogue (Lecture seule)
Navigation publique pour découvrir les offres disponibles.

| Méthode | Route | Description |
| :--- | :--- | :--- |
| `GET` | `/` | Page d'accueil avec navigation |
| `GET` | `/categories` | Liste des catégories |
| `GET` | `/categorie/{id}` | Détail d'une catégorie spécifique |
| `GET` | `/categorie/{id}/prestations` | Liste des prestations liées à une catégorie |
| `GET` | `/prestations` | Liste de toutes les prestations |
| `GET` | `/prestation/{id}` | Détail d'une prestation spécifique |
| `GET` | `/themes` | Liste des thèmes disponibles |
| `GET` | `/theme/{id}` | Détail d'un thème |
| `GET` | `/theme/{id}/coffret_types` | Liste des coffrets-types liés à un thème |
| `GET` | `/coffret_types` | Liste de tous les coffrets-types |
| `GET` | `/coffret_type/{id}` | Détail d'un coffret-type et de ses prestations incluses |

### 2. Gestion des Boxes
Création et gestion des coffrets personnalisés par les utilisateurs.

| Méthode | Route | Description |
| :--- | :--- | :--- |
| `GET` | `/boxes` | Liste de toutes les boxes |
| `GET/POST` | `/box/create` | Création d'une nouvelle box (libellé, description, type). *Protégé par CSRF.* |
| `GET` | `/box/{id}/token` | Génération du token public de partage pour une box |
| `GET` | `/box/detail?token=…` | Consultation d'une box via son lien public sécurisé |
| `GET` | `/prestation/{id}/MesBoxes` | Interface d'ajout d'une prestation à l'une de ses boxes |
| `POST` | `/prestation/{id}/MesBoxes` | Traitement de l'ajout d'une prestation à une box |

### 3. Authentification
Gestion des accès utilisateurs.

| Méthode | Route | Description |
| :--- | :--- | :--- |
| `GET/POST` | `/register` | Inscription (email + mot de passe hashé avec bcrypt) |
| `GET/POST` | `/login` | Connexion utilisateur (Session PHP) |
| `GET` | `/logout` | Déconnexion et destruction de la session |

### 4. API REST (JSON)
Endpoints pour une utilisation asynchrone (AJAX/Fetch) ou par un client tiers.

| Méthode | Route | Description |
| :--- | :--- | :--- |
| `GET` | `/api/prestations` | Retourne toutes les prestations |
| `GET` | `/api/categories` | Retourne toutes les catégories |
| `GET` | `/api/categories/{id}/prestations` | Retourne les prestations d'une catégorie donnée |
| `GET` | `/api/coffrets/{id}/prestations` | Retourne les prestations contenues dans un coffret-type |
| `GET` | `/api/box/{id}` | Retourne les détails d'une box spécifique |

---

## Données de test (Seed)

La base de données est pré-remplie avec des données pour faciliter les tests et le développement.

### Authentification : Note importante ⚠️
Les mots de passe en base de données sont hashés (bcrypt). Étant donné que les mots de passe en clair des comptes de test (comme `admin@gift.net` ou `aurore06@example.org`) ne sont pas fournis, **il est recommandé de créer un nouveau compte** via la route `/register` pour tester les fonctionnalités nécessitant d'être connecté.

### Référentiel

**Catégories :**
* `1` : Restauration
* `2` : Hébergement
* `3` : Attention
* `4` : Activité
* `5` : Petits trucs

**Thèmes :**
* `1` : Sport
* `2` : Famille
* `3` : Culture
* `4` : Gastronomie

**Coffrets-types :**
* `1` : Week-end anniversaire *(Thème : Famille)*
* `2` : Découvrir Nancy *(Thème : Culture)*
* `3` : Gastronomie lorraine *(Thème : Gastronomie)*

### Exemples d'UUID utiles pour les tests

**Prestations :**
* `4cca8b8e-...` : Champagne (20 €)
* `8854b992-...` : Diner Stanislas (60 €)
* `14c4c6d1-...` : Appart Hotel (56 €)
* `38888d1e-...` : Hôtel d'Haussonville (169 €)
* `faa3b035-...` : Visite guidée (11 €)

**Tokens de Boxes publiques (pour la route `/box/detail?token=…`) :**
* *soirée romantique* : `OTYzYNVZo6OOhucGes0/O2KUZgH2ed5S5CkooEQ0Qk0=`
* *quos dolorem libero* : `twmyDtNlmtC0hsxZ6fEw0+maTTfrDEqNH0gjBhTo3BI=`
* *ab exercitationem modi* : `yuGnXxfjEFzPzZLaSPIUQbY0rvz3sXTXG9uliZKrsHs=`