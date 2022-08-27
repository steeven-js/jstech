# JSTech
```
git init
git add .
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/steeven-js/jstech.git
git push -u origin main

git add .
git commit -m "Création des formulaires Contact "
git push -u origin main
```
## 01 Introduction
- [ ]  001 Le programme de la formation étape par étape
- [ ]  002 Qu'est-ce que Symfony et pourquoi l'utiliser
- [ ]  003 Configurer son environnement de développement
- [ ]  004 Choisir son éditeur de code
- [ ]  005 Avec la CLI de Symfony, comment installer Symfony 5

## 02 Les fondations pour comprendre
- [ ]  006 Installation de notre premier projet Symfony
- [ ]  007 L'organisation et l'architecture de Symfony 5_
- [ ]  008 Le premier lancement de Symfony sur notre machine
- [ ]  009 Création de notre première page
- [ ]  010 Twig, le moteur de template pour afficher nos vues à nos utilisateurs
- [ ]  011 Prêt pour attaquer le projet _ On pose les bases
- [ ]  012 Le framework Bootstrap pour le template de notre site
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
- [ ]  030 Mapping de l'entité Product() dans EasyAdmin
- [ ]  031 Refactor de notre EventSubscriber pour l'ajout d'image dans nos produits
- [x]  032 Important - Correctif mise à jour _ Mapping Product() avec EasyAdmin
- [x]  033 Création des produits dans le backoffice
- [x]  034 Création des vues pour afficher nos produits à nos utilisateurs
- [x]  035 Création d'une barre de filtre produit pour faciliter la navigation

## 06 Le panier
- [ ]  036 Comprendre l'utilité de la sessionInterface() de Symfony 5
- [ ]  037 Création du panier et de notre classe Cart()
- [ ]  038 Création de la vue récapitulatif panier avant l'entrée en tunnel d'achat
- [ ]  039 Ajout, diminution et suppression de produit dans panier

## 07 Les adresses
- [ ]  040 Création de l'entité Address() pour les adresses de nos utilisateurs
- [ ]  041 Ajouter, modifier, supprimer une adresse depuis l'espace membre de l'utilisateur

## 08 Les commandes
- [ ]  042 Création de l'entité Carrier() pour stocker nos transporteurs
- [ ]  043 Création de l'entité Order() et OrderDetails()
- [ ]  044 Tunnel d'achat _ Choix de l'adresse de livraison
- [ ]  045 Tunnel d'achat _ Choix du transporteur
- [ ]  046 Tunnel d'achat _ Sommaire de la commande et ajout de style
- [ ]  047 Tunnel d'achat _ Stocker les informations de la commande en base
- [ ]  048 Mapping de nos nouvelles entités avec EasyAdmin

## 09 Le paiement
- [ ]  049 Présentation de l'outil de paiement Stripe
- [ ]  050 Création de notre compte Stripe
- [ ]  051 Installation de Stripe dans notre projet
- [ ]  052 Intégration de Stripe dans notre tunnel d'achat