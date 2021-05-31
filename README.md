# OpenClassroomsProject5 - books exchange website  
OpenClassroomsProject5 - DWJ Course  

# Documentation  

## How to install the website locally  

1. Install the Visual Studio Code IDE :  
`i. Download it from:` [VisualStudioCode](https://code.visualstudio.com/)`, then open it.`  
2. Installing your database system with [WAMP Server](https://wampserver.aviatechno.net/?lang=en) or [XAMPP](https://www.apachefriends.org/index.html) or [MAMP](https://www.mamp.info/en/mac/) on your computer  
3. Set the path of your database system in the environment variables of OS  
`i. Windows gives the possibility to modify the environment variables.`  
`ii. To do this, go to the Windows Control Panel and then System.`  
`iii. On the left, click on Advanced System Settings.`  
`iv. Then in the new window, at the bottom, click on Environment variables.`  
`v. In the new window, at the top, the user environment variables and at the bottom the system environment variables.`  
`vi.In user variable, select the environment variable PATH then click on the button Edit to open the editor and add : `  
`C:\wamp64\bin\mysql\mysql8.0.23\bin `  
`vii. Then click Ok in each of the opened windows.`  
4. Install Composer :  
`i. It is a PHP program, you will find it on this link : ` [Get Composer](https://getcomposer.org)  
`ii. On the home page of the Composer website, click on the Download button: `  
`iii. On Windows, you can click on the link Composer-Setup.exe to install Composer`  
5. Install the [Symfony CLI](https://symfony.com/download)  
6. On the [page](https://github.com/EmmanuelBlanchard/OpenClassroomsProject5), download the code by clicking on the Code button and then click the Download Zip link  
7. Unzip the downloaded folder  
8. Open the Visual Studio Code IDE  
`i. Open the downloaded folder `  
`ii. Open the book_exchange folder, right click on the folder and click on the link: Open in the integrated terminal `  
9. Check that composer is up to date with:  
```
composer self-update
```
10. Installing dependencies with:  
```
composer update
```  
11. The symfony binary also provides a tool to check if your computer meets all requirements.  
Open your console terminal and run this command:  
```
symfony check:requirements
```  
12. Configuring the [Database](https://symfony.com/doc/current/doctrine.html#configuring-the-database)  
`i. The database connection information is stored as an environment variable called DATABASE_URL.`  
`ii. For development, you can find and customize this inside .env (.env file under the vendor folder) :`  
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
`i. Launch your local WAMP server (XAMPP, MAMP) on your computer.`  
`ii. In the built-in terminal which is located in the book_exchange folder, type this command to: `  
```
 php bin/console doctrine:database:create
```  

14. [Migrations](https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html): Creating the Database Tables/Schema  
`i. Database migrations are a way to safely update your database schema both locally and on production. Instead of running the doctrine:schema:update command or applying the database changes manually with SQL statements, migrations allow to replicate the changes in your database schema in a safe manner.`  
`ii. Migrations are available in Symfony applications via the` [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle)`,   which uses the external `[Doctrine Database Migrations](https://github.com/doctrine/migrations) `library. Read the `[documentation](https://www.doctrine-project.org/projects/doctrine-migrations/en/current/index.html)` of that library if you need a general introduction about migrations.`  
`iii. Start by getting the status of migrations:`    
```     
php bin/console  doctrine:migrations:status
```    
`iv. Launch of the migrations of the books_exchange project: `  
```
symfony console doctrine:migrations:migrate
```  

`v. Type yes when the following message appears: `  
```
WARNING! You are about to execute a migration in database "booksexchange" that could result in schema changes and data loss. 
Are you sure you wish to continue? (yes/no) [yes]:
```  

`vi. Migration status: `  
```
symfony console doctrine:migrations:list
```  

15. Loading [Fixtures](https://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html): Adding false data to the database  
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
* [more infos](https://symfony.com/doc/current/setup/symfony_server.html) on local Symfony server  

17. Go to the home page:
* http://127.0.0.1:8000/  

18. If the following message appears:  
Warning: probable security risk  
Click on the Advanced button and then on the 'Accept risk and continue' button