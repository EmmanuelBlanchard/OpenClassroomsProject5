# OpenClassroomsProject5 - books exchange website  
OpenClassroomsProject5 - DWJ Course  

# Documentation  

## How to install the website locally  

1. Install the Visual Studio Code IDE :  
* Download it from: [Visual Studio Code](https://code.visualstudio.com/), then open it.  

2. Installing your database system with [WAMP Server](https://wampserver.aviatechno.net/?lang=en) or [XAMPP](https://www.apachefriends.org/index.html) or [MAMP](https://www.mamp.info/en/mac/) on your computer.  

3. Set the path of your database system in the environment variables of OS.  
* Windows gives the possibility to modify the environment variables.  
* To do this, go to the Windows Control Panel and then System.  
* On the left, click on Advanced System Settings.   
* Then in the new window, at the bottom, click on Environment variables.  
* In the new window, at the top, the user environment variables and at the bottom the system environment variables.  
* In user variable, select the environment variable PATH then click on the button Edit to open the editor and add :  
`C:\wamp64\bin\mysql\mysql8.0.23\bin `  
* Then click OK in each of the opened windows.  

4. Install Composer :  
* It is a PHP program, you will find it on this link : [Get Composer](https://getcomposer.org)  
* On the home page of the Composer website, click on the Download button :  

* On Windows, you can click on the link Composer-Setup.exe to install Composer  
 
5. Install the [Symfony CLI](https://symfony.com/download)  

6. On the [page](https://github.com/EmmanuelBlanchard/OpenClassroomsProject5), download the code by clicking on the Code button and then click the Download Zip link  

7. Unzip the downloaded folder (with [7-Zip](https://www.7-zip.org/))  

8. Open the Visual Studio Code IDE  
* Open the downloaded folder  
* Open the book_exchange folder, right click on the folder and click on the link:  
Open in the integrated terminal  

9. Check that composer is up to date with:  
```
composer self-update
```

10. Installing dependencies with:  
```
composer update
```  

11. The symfony binary also provides a tool to check if your computer meets all requirements.  

* Open your console terminal (located in the books_exchange folder)  
and run this command:  
```
symfony check:requirements
```  

12. Configuring the [Database](https://symfony.com/doc/current/doctrine.html#configuring-the-database)  
* The database connection information is stored as an environment variable called DATABASE_URL.  
* For development, you can find and customize this inside .env (.env file under the vendor folder) :  
```
# .env (or override DATABASE_URL in .env.local to avoid committing your changes)

# customize this line!
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"

# to use mariadb:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.5.8"

# to use sqlite:
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"

# to use postgresql:
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8"

# to use oracle:
# DATABASE_URL="oci8://db_user:db_password@127.0.0.1:1521/db_name"
```  

13. Create the db_name database  
* Launch your local WAMP server (XAMPP, MAMP) on your computer.  
* In the built-in terminal which is located in the book_exchange folder, type this command:    
```
 php bin/console doctrine:database:create
```  

14. [Migrations](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html): Creating the Database Tables/Schema  
* Database migrations are a way to safely update your database schema both locally and on production.  
Instead of running the doctrine:schema:update command or applying the database changes manually  
with SQL statements, migrations allow to replicate the changes in your database schema in a safe manner.  
* Migrations are available in Symfony applications via the [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle),  
 which uses the external [Doctrine Database Migrations](https://github.com/doctrine/migrations) library.  
* Read the [documentation](https://www.doctrine-project.org/projects/doctrine-migrations/en/current/index.html) of that library if you need a general introduction about migrations.  
* Start by getting the status of migrations :  
```     
php bin/console  doctrine:migrations:status
```  
* Launch of the migrations of the books_exchange project :  
```
symfony console doctrine:migrations:migrate
```  
* Type yes when the following message appears :  
```
WARNING! You are about to execute a migration in database "booksexchange" that could result in schema changes and data loss. 
Are you sure you wish to continue? (yes/no) [yes]:
```  
* Migration status:  
```
symfony console doctrine:migrations:list
```  

15. Loading [Fixtures](https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html):  
* Adding false data to the database  
```
	php bin/console doctrine:fixtures:load
```  
or  
```
	symfony console doctrine:fixtures:load
 ```  

16. Launching the [local Symfony server](https://symfony.com/doc/current/setup/symfony_server.html)  
````
symfony server:start
````  
* [More infos](https://symfony.com/doc/current/setup/symfony_server.html) on local Symfony server  

17. Go to the home page:
* http://127.0.0.1:8000/  

18. If the following message appears:  
Warning: probable security risk  
* Click on the 'Advanced' button  
* Click on the 'Accept risk and continue' button  

***

# Documentation (Français)  

## Comment installer le site web localement  

1. Installer l'IDE Visual Studio Code :  
* Téléchargez-le à partir de: [Visual Studio Code](https://code.visualstudio.com/), puis ouvrez-le.  

2. Installation de votre système de base de données avec [WAMP Server](https://wampserver.aviatechno.net/?lang=en) ou [XAMPP](https://www.apachefriends.org/index.html) ou [MAMP](https://www.mamp.info/en/mac/) sur votre ordinateur.  

3. Définissez le chemin de votre système de base de données dans les variables d'environnement du système d'exploitation.  
* Windows donne la possibilité de modifier les variables d'environnement.  
* Pour ce faire, allez dans le Panneau de configuration de Windows, puis dans Système.  
* A gauche, cliquez sur Paramètres système avancés.   
* Puis dans la nouvelle fenêtre, en bas, cliquez sur Variables d'environnement.  

* Dans la nouvelle fenêtre, en haut, les variables d'environnement utilisateur et en bas les variables d'environnement système.  
* Dans les variables utilisateur, sélectionnez la variable d'environnement PATH puis cliquez sur le bouton Modifier pour ouvrir l'éditeur et ajouter :  
`C:\wamp64\bin\mysql\mysql8.0.23\bin `  
* Cliquez ensuite sur OK dans chacune des fenêtres ouvertes.  

4. Installer Composer :  
* C'est un programme PHP, vous le trouverez sur ce lien : [Obtenir Composer](https://getcomposer.org)  
* Sur la page d'accueil du site de Composer, cliquez sur le bouton [Download](https://getcomposer.org/download/):  

* Sous Windows, vous pouvez cliquer sur le lien [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) pour installer Composer.  

5. Installer la [CLI Symfony](https://symfony.com/download)  

6. Sur la [page](https://github.com/EmmanuelBlanchard/OpenClassroomsProject5), téléchargez le code en cliquant sur le bouton Code, puis cliquez sur le lien Download Zip.  

7. Dézippez le dossier téléchargé (avec le logiciel [7-Zip](https://www.7-zip.fr/))  
 
8. Ouvrez l'IDE Visual Studio Code  
* Ouvrez le dossier téléchargé  
* Ouvrez le dossier book_exchange, faites un clic droit sur le dossier et cliquez sur le lien :  
Ouvrir dans le terminal intégré  

9. Vérifiez que Composer est à jour avec:   
```
composer self-update
```

10. Installer les dépendances avec:  
```
composer update
```  

11. Le binaire symfony fournit également un outil permettant de vérifier si votre ordinateur répond à toutes les exigences.  

* Ouvrez votre terminal de console (placé dans le dossier books_exchange)  
et exécutez cette commande:  
```
symfony check:requirements
```  

12. Configuration de la [Base de données](https://symfony.com/doc/current/doctrine.html#configuring-the-database)  
* Les informations de connexion à la base de données sont stockées dans une variable d'environnement appelée DATABASE_URL.  
* Pour le développement, vous pouvez trouver et personnaliser ce fichier à l'intérieur de .env (fichier .env sous le dossier vendor):  
```
# .env (or override DATABASE_URL in .env.local to avoid committing your changes)

# customize this line!
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"

# to use mariadb:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.5.8"

# to use sqlite:
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"

# to use postgresql:
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8"

# to use oracle:
# DATABASE_URL="oci8://db_user:db_password@127.0.0.1:1521/db_name"
```  

13. Créez la base de données db_name  
* Lancez votre serveur local WAMP (XAMPP, MAMP) sur votre ordinateur.  
* Dans le terminal intégré qui se trouve dans le dossier book_exchange, tapez cette commande:   
```
 php bin/console doctrine:database:create
```  

14. [Migrations](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html):  Créer les tables de la base de données/le schéma de la base de données  

* Les migrations de bases de données sont un moyen de mettre à jour en toute sécurité le schéma de votre base de données,  
tant localement qu'en production. Au lieu d'exécuter la commande doctrine:schema:update ou d'appliquer les modifications   
de la base de données manuellement avec des instructions SQL, les migrations permettent de répliquer les changements  
dans le schéma de votre base de données de manière sûre.  

* Les migrations sont disponibles dans les applications Symfony via le [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle),  
qui utilise la bibliothèque externe [Doctrine Database Migrations](https://github.com/doctrine/migrations).  
* Lisez la [documentation](https://www.doctrine-project.org/projects/doctrine-migrations/en/current/index.html) de cette bibliothèque, si vous avez besoin d'une introduction générale sur les migrations.  

* Commencez par obtenir le statut des migrations:  
```     
php bin/console  doctrine:migrations:status
```  

* Lancement des migrations du projet books_exchange:  
```
symfony console doctrine:migrations:migrate
```  

* Tapez yes lorsque le message suivant apparaît:  
```
WARNING! You are about to execute a migration in database "booksexchange" that could result in schema changes and data loss. 
Are you sure you wish to continue? (yes/no) [yes]:
```  

* Statut de migration:  
```
symfony console doctrine:migrations:list
```  

15. Chargement des [Fixtures](https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html)  
 
* Ajout de fausses données à la base de données:  
```
	php bin/console doctrine:fixtures:load
```  
ou  
```
	symfony console doctrine:fixtures:load
 ```  

16. Lancement du [serveur local Symfony](https://symfony.com/doc/current/setup/symfony_server.html)  
````
symfony server:start
````  
* [Plus d'informations](https://symfony.com/doc/current/setup/symfony_server.html) sur le serveur local de Symfony  

17. Allez à la page d'accueil:  

* http://127.0.0.1:8000/  

18. Si le message suivant apparaît : Attention : risque probable de sécurité  

* Cliquer sur le bouton 'Avancé...'  

* Et ensuite, cliquer sur le bouton 'Accepter le risque et poursuivre'  