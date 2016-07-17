# PaypalMiniKit Guide

Guide pour utiliser notre MiniKit pour l'API de Paypal.

## Première étape : Inclure les sources dans votre Projet

Incluez le chargeur automatique fourni avec le Kit.

```sh
require_once __DIR__ . '/path/to/PaypalMiniKit/autoload.php';
```

## Deuxième étape : Connexion à l'API

Dans le fichier **config.xml**, indiquer les informations de votre compte API Paypal.

- **clientid** : correspond à l'ID client donné par Paypal
- **secretkey** : correspond à la clé secrète donnée par par Paypal
- **domainname** : correspond au serveur que vous allez requêter ( pour le développement : https://api.sandbox.paypal.com)

Ces informations seront utilisées par le MiniKit pour requêter l'API.

## Troisième étape : Utiliser notre MiniKit


