Projet Symfony : Gestion de collection de voitures(exotic et vintage) et galeries
Etudiant: Mohamed Taieb Mhamdi
Description :
Ce projet permet à un utilisateur (Member) de gérer une collection de voitures (CollectionVoitures)
et de créer des galeries associées. Chaque membre possède une collection de voitures, et chaque
galerie peut contenir plusieurs voitures.

État actuel :
- Les entités et leurs relations Doctrine sont correctement configurées :
    * Member ↔ CollectionVoitures (OneToOne)
    * CollectionVoitures ↔ Voiture (OneToMany)
    * Voiture ↔ Galerie (ManyToMany)
    * Galerie ↔ Member (ManyToOne)
- Les repositories sont opérationnels.
- Les contrôleurs suivants sont fonctionnels :
    * CollectionVoituresController
    * VoitureController
- Le projet se connecte à une base de données MySQL locale.

Éléments manquants :
- Interface d’accueil du site (page d’entrée non encore développée)
- Système complet d’authentification et de gestion des utilisateurs (login / registration)
- CRUD et vues Twig pour Galerie et Member
- Tests unitaires non implémentés

Routes disponibles :
---------------------------------------------------------
# Routes CollectionVoitures
- `/collection/` → Liste des collections
- `/collection/{id}` → Détails d'une collection spécifique

# Routes Voitures
- `/voitures/` → Liste des voitures
- `/voitures/{id}` → Détails d'une voiture spécifique
---------------------------------------------------------

Procédure de test :
1. Lancer le serveur local :
   `symfony server:start`

2. Créer la base de données :
   `symfony console doctrine:database:create`

3. Créer le schéma de base de données :
   `symfony console doctrine:schema:create`

4. Vérifier la validité du schéma :
   `symfony console doctrine:schema:validate`

5. Charger les données de test avec les DataFixtures :
   `symfony console doctrine:fixtures:load`

6. Accéder à l’application :
   http://127.0.0.1:8000

Remarques :
Le projet est actuellement en phase intermédiaire de développement (mi-parcours).

Les principales entités et contrôleurs de base sont prêts pour les prochaines itérations.
