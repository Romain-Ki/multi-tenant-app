# Documentation du projet Mutuelles & Clients

Ce projet est une application Laravel permettant aux **mutuelles** et aux **clients** de gérer leur espace personnel, leurs remboursements et leurs échanges sécurisés.

---

## Sommaire

- [Routes disponibles](#routes-disponibles)
  - [Routes publiques](#routes-publiques)
  - [Routes client](#routes-client)
  - [Routes mutuelle](#routes-mutuelle)
- [Base de données](#base-de-données)
  - [mutuelles](#mutuelles)
  - [users](#users)
  - [clients](#clients)
  - [offre_santes](#offre_santes)
  - [demandes_remboursements](#demandes_remboursements)
  - [echanges_dossier](#echanges_dossier)
  - [Autres tables](#autres-tables)
- [Middleware et Authentification](#middleware-et-authentification)

---
# Documentation API

## ✅ Routes générales

| Type de requête | URL               | Donnée d'entrée | Donnée de sortie          |
|-----------------|-------------------|-----------------|---------------------------|
| GET             | `/`               | -               | HTML                      |
| GET             | `/mutuelles`      | -               | JSON [{ "id": "UUID", "nom": "String"}, ...] |

---

## ✅ Routes Mutuelles

| Type de requête | URL                               | Donnée d'entrée  | Donnée de sortie         |
|-----------------|-----------------------------------|------------------|--------------------------|
| GET             | `/mutuelle/home`                  | -                | HTML                     | *(protégé par middleware `auth:mutuelles`)* |
| GET             | `/mutuelle/login`                 | -                | HTML                     | - |
| POST            | `/mutuelle/login`                 | voir détail      | HTML                     | - |
| GET             | `/mutuelle/logout`                | -                | HTML                     | - |
| GET             | `/mutuelles/create`               | -                | HTML                     | - |
| POST            | `/mutuelles/create`               | voir détail      | HTML                     | - |
| GET             | `/mutuelles/{mutuelle_uuid}`      | -                | JSON (Mutuelle)          | - |
| GET             | `/mutuelles/{mutuelle_uuid}/edit` | -                | HTML                     | - |
| PUT             | `/mutuelles/{mutuelle_uuid}`      | -                | HTML                     | - |
| DELETE          | `/mutuelles/{mutuelle}`           | -                | HTML                     | - |
| GET             | `/mutuelle/searchClient/{numero}` | -                | JSON (Client)            | *(protégé par middleware `auth:mutuelles`)* |
| GET             | `/mutuelle/clients`               | -                | JSON ([Client], ...)     | *(protégé par middleware `auth:mutuelles`)* |

---

## ✅ Routes Clients

| Type de requête | URL                      | Donnée d'entrée                       | Donnée de sortie          |
|-----------------|--------------------------|---------------------------------------|---------------------------|
| GET             | `/client/login`          | -                                     | HTML                      | - |
| POST            | `/client/login`          | voir détail                           | HTML                      | - |
| GET             | `/register`              | -                                     | HTML                      | - |
| POST            | `/register`              | voir détail                           | HTML                      | - |
| GET             | `/client/home`           | -                                     | HTML                      | *(protégé par middleware `auth:clients`)* |
| GET             | `/client/logout`         | -                                     | HTML                      | - |
| GET             | `/client/logout`         | -                                     | HTML                      | - |
| GET             | `/client/logout`         | -                                     | HTML                      | - |

---

## 📥 Détail des formulaires

### 🔹 POST Login (Mutuelle / Client)
- **Champs attendus :**
  - `email_contact` (string)
  - `password` (string)

### 🔹 POST Register (Mutuelle)
- **Champs attendus :**
  - `nom` (string)
  - `email_contact` (email unique)
  - `password` (string, min:6)
  - `password_confirmation` (string)

### 🔹 POST Register (Client)
- **Champs attendus :**
  - `nom` (string)
  - `prenom` (string)
  - `numero_securite_sociale_encrypted` (string)
  - `email` (email unique)
  - `password` (string, min:6)
  - `password_confirmation` (string)
  - `telephone` (string)
  - `adresse` (string)
  - `rib_encrypted` (string)
  - `historique_medical_encrypted` (nullable string)
  - `mutuelle_id` (UUID)

---

## 🔍 Remarques techniques

- Toutes les routes **GET** rendent du **HTML** ou du **JSON** en mettant le header `accept`:`application/json` dans la requête.
- L'accès à certaines routes est **protégé par les middlewares** `auth:mutuelles` ou `auth:clients` dependant du type d'authentification.

## Base de données

### `mutuelles`

Contient les informations sur les mutuelles partenaires.

| Champ            | Type        | Description                                |
|:-----------------|:------------|:-------------------------------------------|
| id               | CHAR(36)    | Identifiant unique UUID                   |
| nom              | VARCHAR(255)| Nom de la mutuelle                        |
| password         | VARCHAR(255)| Mot de passe hashé                        |
| email_contact    | VARCHAR(255)| Email de contact                          |
| created_at       | TIMESTAMP   | Date de création                          |
| updated_at       | TIMESTAMP   | Date de dernière mise à jour              |

---

### `users`

Table standard Laravel pour les utilisateurs administratifs (non clients/mutuelles).

| Champ            | Type        | Description                                |
|:-----------------|:------------|:-------------------------------------------|
| id               | BIGINT      | Identifiant auto-incrémenté                |
| name             | VARCHAR(255)| Nom d'utilisateur                         |
| email            | VARCHAR(255)| Email unique                              |
| password         | VARCHAR(255)| Mot de passe hashé                        |
| email_verified_at| TIMESTAMP   | Vérification d'email                      |
| remember_token   | VARCHAR(100)| Jeton "remember me"                        |
| created_at       | TIMESTAMP   | Date de création                          |
| updated_at       | TIMESTAMP   | Date de dernière mise à jour              |

---

### `clients`

Contient les informations sur les clients assurés.

| Champ                                 | Type        | Description                                    |
|:--------------------------------------|:------------|:-----------------------------------------------|
| id                                    | CHAR(36)    | Identifiant unique UUID                        |
| mutuelle_id                           | CHAR(36)    | Clé étrangère liée à la table `mutuelles`      |
| nom                                   | VARCHAR(255)| Nom du client                                 |
| prenom                                | VARCHAR(255)| Prénom du client                              |
| numero_securite_sociale_encrypted     | BLOB        | Numéro de Sécurité Sociale (crypté)            |
| numero_securite_sociale_hashed        | BLOB        | Hash du Numéro de Sécurité Sociale             |
| email                                 | VARCHAR(255)| Email du client (facultatif)                  |
| password                              | VARCHAR(255)| Mot de passe hashé                            |
| telephone                             | VARCHAR(255)| Téléphone (facultatif)                        |
| adresse                               | TEXT        | Adresse (facultatif)                          |
| rib_encrypted                         | BLOB        | RIB bancaire crypté (facultatif)               |
| historique_medical_encrypted          | BLOB        | Historique médical crypté (facultatif)         |
| created_at                            | TIMESTAMP   | Date de création                              |
| updated_at                            | TIMESTAMP   | Date de dernière mise à jour                  |

---

### `offre_santes`

Liste des offres de soins proposées par les mutuelles.

| Champ             | Type         | Description                                  |
|:------------------|:-------------|:---------------------------------------------|
| id                | CHAR(36)     | Identifiant unique UUID                      |
| mutuelle_id       | CHAR(36)     | Clé étrangère liée à `mutuelles`              |
| titre             | VARCHAR(255) | Titre de l'offre                             |
| description       | TEXT         | Description facultative                     |
| type_soin         | VARCHAR(255) | Type de soin (ex: optique, dentaire, etc.)    |
| remboursement_max | DECIMAL(10,2)| Montant maximal de remboursement             |
| date_debut        | DATE         | Date de début de validité                    |
| date_fin          | DATE         | Date de fin de validité                      |
| created_at        | TIMESTAMP    | Date de création                             |
| updated_at        | TIMESTAMP    | Date de dernière mise à jour                 |

---

### `demandes_remboursements`

Demandes de remboursement faites par les clients.

| Champ                | Type          | Description                                |
|:---------------------|:--------------|:-------------------------------------------|
| id                   | CHAR(36)      | Identifiant unique UUID                   |
| client_id            | CHAR(36)      | Clé étrangère vers `clients`               |
| offre_id             | CHAR(36)      | Clé étrangère vers `offre_santes` (nullable)|
| statut               | ENUM          | Statut (`en_attente`, `en_cours`, `validee`, `refusee`) |
| montant              | DECIMAL(10,2) | Montant demandé                           |
| date_demande         | DATE          | Date de la demande                        |
| type_soin            | VARCHAR(255)  | Type de soin                              |
| justificatif_path    | TEXT          | Chemin vers justificatif (fichier stocké)  |
| justificatif_encrypted| BLOB         | Justificatif crypté                       |
| commentaire          | TEXT          | Commentaires éventuels                    |
| created_at           | TIMESTAMP     | Date de création                          |
| updated_at           | TIMESTAMP     | Date de dernière mise à jour              |

---

### `echanges_dossier`

Échanges liés aux demandes de remboursement (chat, pièces jointes, etc.).

| Champ                 | Type        | Description                                |
|:----------------------|:------------|:-------------------------------------------|
| id                    | CHAR(36)    | Identifiant unique UUID                   |
| demande_id            | CHAR(36)    | Clé étrangère vers `demandes_remboursements` |
| auteur                | VARCHAR(255)| Auteur du message                         |
| message               | TEXT        | Contenu du message                        |
| piece_jointe_path     | TEXT        | Chemin de la pièce jointe                  |
| piece_jointe_encrypted| BLOB        | Pièce jointe cryptée                      |
| date_echange          | TIMESTAMP   | Date de l'échange                         |
| created_at            | TIMESTAMP   | Date de création                          |
| updated_at            | TIMESTAMP   | Date de dernière mise à jour              |

---

### Autres tables

- `sessions` : Gestion des sessions utilisateurs.
- `password_reset_tokens` : Gestion des tokens de réinitialisation de mot de passe.

---

## Middleware et Authentification

- **auth:clients** : Protège les routes pour les clients connectés.
- **auth:mutuelles** : Protège les routes pour les mutuelles connectées.
- **Guards personnalisés** Laravel (`clients`, `mutuelles`) pour une séparation stricte des espaces utilisateurs.

---

