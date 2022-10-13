# Connexion OAuth

## Création d'un client OAuth

Pour créer un client OAuth, il faut utiliser la commande suivante :

    $ php bin/console league:oauth2-server:create-client

Cette commande va créer un client OAuth avec les informations suivantes :
* `name` : le nom du client
* `client_id` : identifiant du client
* `client_secret` : secret du client

## Grant type

La connexion recommandée pour les clients est le grant type `client_credentials`.
Pour cela, il faut utiliser le `client_id` et le `client_secret` du client OAuth.

1. Faire une requête HTTP POST sur l'URL `/oauth/token` avec les paramètres suivants :
    * `grant_type` : `client_credentials`
    * `client_id` : identifiant du client OAuth
    * `client_secret` : secret du client OAuth
2. Récupérer le token dans la réponse de la requête
3. Utiliser le token dans les requêtes HTTP suivantes en ajoutant le header `Authorization` avec la valeur `Bearer <token>`
