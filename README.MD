# JSTech
```
git init
git add .
git commit -m "Vérifications et ajustements"
git branch -M main
git remote add origin https://github.com/steeven-js/jstech.git
git push -u origin main

git add .
git commit -m "Vérifications et ajustements + Display flex category Mobile"
git push -u origin main 
```
## 01 Introduction
- [x]  001 Le programme de la formation étape par étape
- [x]  002 Qu'est-ce que Symfony et pourquoi l'utiliser
- [x]  003 Configurer son environnement de développement
- [x]  004 Choisir son éditeur de code
- [x]  005 Avec la CLI de Symfony, comment installer Symfony 5

## 02 Les fondations pour comprendre
- [x]  006 Installation de notre premier projet Symfony
- [x]  007 L'organisation et l'architecture de Symfony 5_
- [x]  008 Le premier lancement de Symfony sur notre machine
- [x]  009 Création de notre première page
- [x]  010 Twig, le moteur de template pour afficher nos vues à nos utilisateurs
- [x]  011 Prêt pour attaquer le projet _ On pose les bases
- [x]  012 Le framework Bootstrap pour le template de notre site
## 03 Les membres

- [x]  013 Création de notre première entité _ User()
- [x]  014 L'ORM Doctrine pour faire de notre entité User() une table en base de donnée
- [x]  015 Création de notre formulaire d'inscription
- [x]  016 Sauvegarder les informations du formulaire en base de donnée
- [x]  017 Sécurité _ Encodage des mots de passe de nos utilisateurs
- [x]  018 Valider les données grâce au composant Validator de Symfony 5
- [x]  019 Création de notre formulaire de login
- [x]  020 Les vues privées _ L'espace membre de l'utilisateur
- [x]  021 Les vues privées _ Modification du mot de passe de l'utilisateur
- [x]  022 Mise à jour de notre template pour afficher l'utilisateur et les routes
- [x]  023 Vous êtes arrivé jusqu'ici, bravo ! On fait le point en vidéo

## 04 L'administration
- [x]  024 Présentation du bundle EasyAdmin v3 dans notre projet Symfony 5
- [x]  025 Installation, configuration et mapping de EasyAdmin avec l'entité User()

## 05 Les produits
- [x]  026 Création de l'entité Category() pour organiser nos produits
- [x]  027 Mapping de l'entité Category() dans EasyAdmin
- [x]  028 Création de l'entité Product()
- [x]  029 Important - Le point avant de continuer sur les mises à jour
- [x]  030 Mapping de l'entité Product() dans EasyAdmin
- [x]  031 Refactor de notre EventSubscriber pour l'ajout d'image dans nos produits
- [x]  032 Important - Correctif mise à jour _ Mapping Product() avec EasyAdmin
- [x]  033 Création des produits dans le backoffice
- [x]  034 Création des vues pour afficher nos produits à nos utilisateurs
- [x]  035 Création d'une barre de filtre produit pour faciliter la navigation

## 06 Le panier
- [x]  036 Comprendre l'utilité de la sessionInterface() de Symfony 5
- [x]  037 Création du panier et de notre classe Cart()
- [x]  038 Création de la vue récapitulatif panier avant l'entrée en tunnel d'achat
- [x]  039 Ajout, diminution et suppression de produit dans panier

## 07 Les adresses
- [x]  040 Création de l'entité Address() pour les adresses de nos utilisateurs
- [x]  041 Ajouter, modifier, supprimer une adresse depuis l'espace membre de l'utilisateur

## 08 Les commandes
- [x]  042 Création de l'entité Carrier() pour stocker nos transporteurs
- [x]  043 Création de l'entité Order() et OrderDetails()
- [x]  044 Tunnel d'achat _ Choix de l'adresse de livraison
- [x]  045 Tunnel d'achat _ Choix du transporteur
- [x]  046 Tunnel d'achat _ Sommaire de la commande et ajout de style
- [x]  047 Tunnel d'achat _ Stocker les informations de la commande en base
- [x]  048 Mapping de nos nouvelles entités avec EasyAdmin

## 09 Le paiement
- [x]  049 Présentation de l'outil de paiement Stripe
- [x]  050 Création de notre compte Stripe
- [x]  051 Installation de Stripe dans notre projet
- [x]  052 Intégration de Stripe dans notre tunnel d'achat
- [x]  053. Ajout de la livraison dans les informations envoyées à Stripe
- [x]  054. Création des vues "Merci pour votre commande / Echec de paiement"
- [x]  055. Afficher les commandes dans l'espace membre de nos utilisateurs

## 10 Les emails
- [x] 056. Pourquoi choisir Mailjet pour la gestion des emails transactionnels
- [x] 057. Création de notre compte Mailjet
- [x] 058. Intégration de la librairie Mailjet dans notre projet Symfony
- [x] 059. Création d'une classe Mail() et envoie de notre premier mail 
- [x] 060. Envoyer les emails à nos clients dans les différents controllers

## 11 Pour aller plus loin
- [x] 061. Créer une mécanique de gestion de statut de commande pour informer l'utilisateur
- [x] 062. Mettre des produits à la une pour les afficher sur la homepage
- [ ] 063. Ajouter une fonctionnalité de gestion du header depuis le backoffice
- [ ] 064. Création de la mécanique de mot de passe oublié.
- [ ] 065. Sécuriser l'accès à notre backoffice pour les administrateurs
- [ ] 066. Gérer les vues "erreurs" de Symfony pour préparer notre mise en production
- [ ] 067. Mise à jour graphique et création de la page "nous contacter"
- [ ] 068. Mettre son site en production et dépôt GIT du projet