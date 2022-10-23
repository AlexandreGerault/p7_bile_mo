
# BileMo - Project 7 from PHP/Symfony developper route on OpenClassrooms

A simple API to list two resources :
* users
* phones

Phones can only be listed by an authenticated user.
Users can be listed and created/deleted by an authenticated user.
## Installation

To install the project locally, you need to have Docker and Docker-Compose installed locally. Then simply run these commands:

```bash
  git clone git@github.com:AlexandreGerault/p7_bile_mo.git
  cd p7_bile_mo
  make install
```

You are now ready to visit the website on http://localhost:3333 by default. You can change settings in the `.env`, at the root of the project, where Docker environnement variables stands. You can also customize Symfony `.env` located inside `apps/symfony` folder.

If you get an error from the doctrine commands, wait for the MySQL container to end booting. Then use `make install` again.
## Run Locally

Make sure you installed the project first, referring to the [Installation](#Installation) section. Then, if the project has already been setup once, you just have to type
```bash
  make up
```

## Features

### Authentication
- Create an OAuth client for BileMo's customer
- Ask a new access token with client id and client secret

### Users
- List users of a customer
- Create a new user
- Delete a user
- Get a user details

## Phones
- List all phones
- Get a phone details

## Tech Stack

**Server:** PHP 8.1, Symfony 6.1

## Documentation

### UML diagrams

UML diagrams are available in the `docs` folder.

### API Reference

An API reference is available [here](https://documenter.getpostman.com/view/23966997/2s847LMWkN).

