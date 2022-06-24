================ ETAPES DE CREATION DEAL ===========================

Etape 1 : Création de la base de données 
        - La base, les tables, les champs, etc (via php my admin)
        - Les contraintes peuvent attendre éventuellement (mais quand même les insérer comme "index")

Etape 2 : Création d'une arborescence 
        - Reflexion de l'organisation de votre dossier de travail (page à la racine ? dossiers ?)
        - Création de votre page template/modele (c'est à dire, création d'un premier modele, d'un squelette de page, puis faire la découpe totale avec require/include pour ensuite n'avoir besoin que de dupliquer cette page modele pour créer toutes les autres pages)

Etape 3 : Création des fonctionnalités membres 
        - Inscription utilisateur (formulaire, puis requete d'insertion, controles importants : gestion des doublons on ne permet pas à un utilisateur de s'inscrire avec un pseudo qui existerait déjà dans la BDD, mot de passe crypté(password_hash))
        - Connexion utilisateur (password_verify pour vérifier un mdp crypté avec password_hash)
        - Page profil avec un récap des infos de l'utilisateur actuellement connecté
        - Gestion des redirections, c'est à dire, si un utilisateur est connecté on ne lui laisse plus la possibilité d'accéder ni à la page inscription ni connexion, si jamais il essaye... redirection!   Le menu doit aussi être dynamique à ce niveau là(inscription et connexion deviennent : profil et deconnexion).

Etape 4 : Création de la page BACKOFFICE - Gestion des membres 
        - Formulaire d'ajout de membre sur cette page (avec la possibilité de choisir le statut utilisateur (0 membre  1 admin))
        - Affichage des membres
        - Ajout des actions de visualisation d'un membre, modification d'un membre, suppression d'un membre 

Etape 5 : Création de la page BACKOFFICE - Gestion des catégories 
        - Formulaire d'ajout de catégories
        - Affichage des catégories 
        - Suppression des catégories
        - Modification des catégories 

Etape 6 : Création des autres pages BACKOFFICE : Gestion des avis, des commentaires, des annonce... Similaires aux étapes 4 et 5
        - On veut gérer la sécurité si un membre non-administrateur essaie de se connecter sur ces pages là, on le redirige !
        - Si un utilisateur est connecté en Administrateur, alors il a un menu supplémentaire pour toutes les pages BACKOFFICE

Etape 7 : Création de la page FRONT Ajout d'annonce 
        - Formulaire d'ajout d'annonce 
        - La gestion de l'upload d'image à gérer... 

Etape 8 : Création de la page FRONT Accueil 
        - Affichage des annonces sur la page d'accueil 

Etape 9 : Création de la page FRONT Fiche Produit
        - Affichage de l'annonce au complet
        - Formulaire d'ajout de commentaires
        - Eventuellement option d'achat 

Etape 10 : Pages annexes, amélioration du code, du visuel, mise en ligne !
