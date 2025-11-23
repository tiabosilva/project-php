🏎️ Projet Symfony – MyCars

Gestion de collections de voitures & galeries interactives
Étudiant : Mohamed Taieb Mhamdi – Télécom SudParis

📌 1. Présentation générale

MyCars est une application web développée avec Symfony 7 permettant :

aux utilisateurs authentifiés de gérer leur propre collection privée de voitures ;

d’ajouter, modifier, visualiser et supprimer des voitures ;

de créer des galeries publiques ou privées regroupant plusieurs voitures de leur collection ;

de consulter les galeries publiques des autres membres ;

d’accéder, pour les administrateurs, à un dashboard complet via EasyAdmin pour gérer toutes les entités du système.

L’interface utilise Bootstrap 5, intégré dans les gabarits Twig.

📌 2. Architecture des entités
✔ Member

Possède exactement une collection privée (OneToOne)

Peut créer plusieurs galeries (OneToMany)

✔ CollectionVoitures

Appartient à un seul membre (OneToOne)

Contient plusieurs voitures (OneToMany)

✔ Voiture

Appartient à une collection (ManyToOne)

Peut appartenir à plusieurs galeries (ManyToMany)

Possède une image uploadée (optionnelle)

✔ Galerie

Appartient à un créateur (ManyToOne Member)

Contient plusieurs voitures (ManyToMany)

Peut être publique ou privée

📌 3. Fonctionnalités réalisées
🎯 Éléments obligatoires — VALIDÉS
Élement attendu	Statut
Consultation d’un objet (voiture ou galerie)	✔ Fait
Consultation de la liste d’objets d’un inventaire (voitures d’une collection)	✔ Fait
Navigation d’un inventaire vers ses objets	✔ Fait
Gabarits Twig + intégration Bootstrap	✔ Fait
Ajout de l’entité Galerie + relation ManyToMany avec Voiture	✔ Fait
CRUD complet sur les galeries	✔ Fait
Création contextualisée d’un objet (voiture attachée à la collection du user)	✔ Fait
Upload d’images pour les voitures	✔ Fait
Authentification + documentation des comptes	✔ Fait

→ 100% des éléments obligatoires validés.

🎯 Éléments optionnels — VALIDÉS
Option avancée	Statut
Protection des routes réservées aux membres	✔ Fait
Protection des CRUD (uniquement propriétaire ou admin)	✔ Fait
Ajout de voitures dans les galeries	✔ Fait

→ Toutes les options pertinentes validées.

📌 4. Parcours utilisateur
👤 Utilisateur non connecté

Peut consulter les galeries publiques

Est redirigé vers la page de login pour toute action privée

Ne peut pas visualiser les galeries privées

👤 Utilisateur connecté (ROLE_USER)

Possède sa propre collection privée

Peut ajouter, modifier, supprimer ses voitures

Peut créer des galeries publiques/privées

Peut ajouter des voitures dans ses galeries

Peut consulter toutes les galeries publiques

👑 Administrateur (ROLE_ADMIN)

Redirection automatique vers /admin après login

Accède à toutes les entités via EasyAdmin

Peut gérer Members, Collections, Voitures, Galeries

Ne voit pas les éléments "Ma collection" / "Mes galeries" dans la navbar

📌 5. Documentation des comptes disponibles

Comptes fournis dans les Fixtures :

Rôle	Email	Mot de passe
Admin	admin@local	admin123
Utilisateur 1	user1@local	user123
Utilisateur 2	user2@local	user123
📌 6. Routes principales
🔹 Collection

/collection — Voir la collection du user

/collection/new — Création automatique à l’inscription

/collection/{id} — Détails & voitures

🔹 Voiture

/voiture/new — Ajout contextualisé (uniquement depuis la collection)

/voiture/{id} — Détails

/voiture/{id}/edit — Modification

🔹 Galeries

/galerie — Mes galeries

/galerie/public — Galeries publiques

/galerie/{id} — Détails

/galerie/{id}/edit — Modifier une galerie

/galerie/{id} (DELETE) — Supprimer

🔹 Administration

/admin — Dashboard complet

Listing CRUD via EasyAdmin pour :

Members

Collections

Voitures

Galeries

⚠️ 7. Règles importantes du fonctionnement
✅ 1. Un utilisateur doit créer sa collection AVANT de pouvoir créer une galerie

Une galerie ne peut contenir que des voitures appartenant à la collection du membre → prérequis logique.

✅ 2. Les voitures ne peuvent être créées QUE depuis la page de la collection

Il n’existe pas de bouton “Créer voiture” dans la navbar :
→ la création est contextuelle à la collection du user.

➜ Cela assure la cohérence des données :

aucune voiture orpheline

aucune galerie contenant une voiture étrangère

droits d’accès toujours respectés

📌 8. Installation & lancement
1️⃣ Installer les dépendances
symfony composer install

2️⃣ Créer la base
symfony console doctrine:database:create

3️⃣ Créer le schéma
symfony console doctrine:schema:create

4️⃣ Charger les données de démonstration
symfony console doctrine:fixtures:load

5️⃣ Lancer le serveur
symfony server:start
----------------------------------------------------
Remarque : Les fixtures sont regroupées dans 2 fichiers seulement, par choix personnel, pour garder un ensemble simple et lisible.

📌 9. Conclusion

Le projet MyCars respecte l’intégralité des exigences du sujet :

modèle de données complet

relations Doctrine avancées

gabarits Twig professionnels

sécurité, rôles et redirections

intégration EasyAdmin

UX cohérente et intuitive
