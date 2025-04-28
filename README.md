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

# Documentation des Routes

> **Note** : Toutes les routes API attendent et renvoient des données **au format JSON**, sauf indication contraire pour les routes affichant directement du HTML (formulaires).

---

## Routes publiques

| Méthode | URL         | Nom        | Description                        | Entrée attendue | Sortie attendue |
|:--------|:------------|:-----------|:-----------------------------------|:----------------|:----------------|
| GET     | `/`          | login      | Page d'accueil (`welcome.blade.php`) | Aucune          | HTML            |
| GET     | `/mutuelles` | mutuelles  | Liste des mutuelles disponibles    | Aucune          | JSON            |

---

## Routes Client

| Méthode | URL               | Nom              | Description                           | Entrée attendue             | Sortie attendue |
|:--------|:------------------|:-----------------|:--------------------------------------|:-----------------------------|:----------------|
| GET     | `/client/login`    | client.login     | Formulaire de connexion client       | Aucune                       | HTML              |
| POST    | `/client/login`    | client.login     | Traitement de la connexion client    | `{ "email_contact": string, "password": string }` | JSON |
| GET     | `/register`        | clients.register | Formulaire d'inscription client      | Aucune                       | HTML              |
| POST    | `/register`        | clients.store    | Traitement de l'inscription client   | `{ "nom": string, "prenom": string, "numero_securite_sociale_encrypted": string (max 15 char),  "email": string, "password": string (min 6 char), "telephone": string, "adresse": string, "rib_encrypted": string (max 35 char), "historique_medical_encrypted": string}` | JSON            |
| GET     | `/client/logout`   | client.logout    | Déconnexion du client                | Aucune                       | JSON              |
| GET     | `/client/home`     | client.home      | Accès au tableau de bord client (authentifié) | Aucune              | HTML              |

---

## Routes Mutuelle

| Méthode | URL                                 | Nom                                 | Description                                               | Entrée attendue             | Sortie attendue |
|:--------|:------------------------------------|:------------------------------------|:----------------------------------------------------------|:-----------------------------|:----------------|
| GET     | `/mutuelle/login`                   | mutuelles.login                    | Formulaire de connexion mutuelle                         | Aucune                       | HTML            |
| POST    | `/mutuelle/login`                   | mutuelle.login                     | Traitement de la connexion mutuelle                      | `{ "email_contact": string, "password": string }` | JSON            |
| GET     | `/mutuelle/logout`                  | mutuelle.logout                    | Déconnexion de la mutuelle                               | Aucune                       | JSON            |
| GET     | `/mutuelle/home`                    | mutuelle.home                      | Tableau de bord de la mutuelle (authentifié)             | Aucune                       | HTML            |
| GET     | `/mutuelles/create`                 | mutuelles.create                   | Formulaire de création de mutuelle                      | Aucune                       | HTML            |
| POST    | `/mutuelles`                        | mutuelles.store                    | Enregistrement d'une mutuelle                           | `{ "nom": string, "email_contact": string, "password": string }` | JSON            |
| GET     | `/mutuelles/{mutuelle}`             | mutuelles.show                     | Détail d'une mutuelle                                    | ID en URL                    | JSON            |
| GET     | `/mutuelles/{mutuelle}/edit`         | mutuelles.edit                     | Formulaire d'édition d'une mutuelle                      | ID en URL                    | HTML            |
| PUT     | `/mutuelles/{mutuelle}`             | mutuelles.update                   | Mise à jour d'une mutuelle                               | `{ "nom": string, "email_contact": string, "password": string (optionnel) }` | JSON            |
| DELETE  | `/mutuelles/{mutuelle}`             | mutuelles.destroy                  | Suppression d'une mutuelle                               | ID en URL                    | JSON            |
| POST    | `/mutuelle/register`                | mutuelle.register                  | Enregistrement d'une mutuelle via formulaire             | `{ "nom": string, "email_contact": string, "password": string }` | JSON            |
| GET     | `/mutuelle/searchClient/{numero}`   | mutuelle.searchClientByNumeroSocial | Recherche d'un client via numéro de sécurité sociale (authentifié) | Numéro en URL         | JSON            |
| GET     | `/mutuelle/clients`                 | mutuelle.clients                   | Liste des clients liés à la mutuelle (authentifié)       | Aucune                       | JSON            |

---

## Remarques

- Les routes de type `GET` affichant un formulaire ou un tableau de bord rendent **directement du HTML**.
- Toutes les routes d'actions (`POST`, `PUT`, `DELETE`, certaines `GET`) traitent des données JSON en entrée et répondent avec du JSON (messages de succès, erreurs, ou données).
- Pour récuperer du json depuis un `GET` il est necessaire d'ajouter un header `Accept`:`application/json` dans la requete

---

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

