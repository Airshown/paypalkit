# PaypalMiniKit Guide

Guide pour utiliser notre MiniKit pour l'API de Paypal.

## Premi�re �tape : Inclure les sources dans votre Projet

Incluez le chargeur automatique fourni avec le Kit.

```sh
require_once __DIR__ . '/path/to/PaypalMiniKit/autoload.php';
```

## Deuxi�me �tape : Connexion � l'API

Dans le fichier **config.xml**, indiquer les informations de votre compte API Paypal.

- **clientid** : correspond � l'ID client donn� par Paypal
- **secretkey** : correspond � la cl� secr�te donn�e par par Paypal
- **domainname** : correspond au serveur que vous allez requ�ter ( pour le d�veloppement : https://api.sandbox.paypal.com)

Ces informations seront utilis�es par le MiniKit pour requ�ter l'API.

## Troisi�me �tape : Utiliser notre MiniKit


