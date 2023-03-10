# Projet 5 Blog en php

## Requisites:

 - Docker
 - Docker compose
 

## Setup:
Start the containers by typing in you console
`docker-compose up -d`
when the containers are started go to :
[The adminer container](localhost:8080)

 - login: root
 - password: root
 - database name: test
 and import SetupDb.sql to set the database.
 

## Links:
[The Blog](localhost:80)

> to connect as admin use: 
> login: root 
> password: RootRoot

[Email catcher](localhost:8090)
[Adminer](localhost:8080)

## Adding another admin
The admin role can only be setup in the database.
To setup a user as admin select a user and change is role from "user" to "admin"
> Written with [StackEdit](https://stackedit.io/).



