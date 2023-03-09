# projet_5_blog_php
<<<<<<< HEAD

Creation of a blog app for the 5th project of the Php Developper cursus on openclassrooms  

prerequisite:  
git,  
composer

Installation:  
if you do not have a local dev environment setup, you can use the docker repository.  
clone this repo  
cmd : git clone URL ./blog  
install and init composer
cmd : composer install  
composer dump-autoload
=======
Project setup using docker:  
  
prerequisites:  
Docker, dockercompose  
  
In the project folder type docker-compose up

install and init composer in the docker container.
cmd :

composer install  
composer dump-autoload
after that go to localhost:/8080  
(name: root password: root db:test)
import the SetupDb.sql  
  
you can now go to localhost:80 
The base admin is login: root pw: RootRoot  

to see the email sent go to localhost:8090.  
  
If you want to setup a new admin go to adminer (localhost:/8080)
and change the role of the selected user to "admin".
  
  
  
If you use a *amp server:  
You will need to update your server rules.  
for apache copy the apache2.conf in place of your 000-default.conf  
for nginx you will need to change the settings with nginx.conf (not tested)  
use your favorite tools to create db import the SetupDb.sql and change the name and port of the db in bootstrap  
you can connect to the website  
for catching mail you'll have to install a mail catcher (like maildev) and change the mailer host in src/Service/MailService  
(This solution has not been tested I strongly advise you to use docker to setup this app)
  
  


>>>>>>> develop


