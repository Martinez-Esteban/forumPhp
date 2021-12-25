# Forum PHP

Notre projet est un site web sous forme de forum avec lequel vous pourrez créer un compte, écrire des articles et les modifier. Vous pourrez également consulter les articles des autres utilisateurs.

## Membres du projet

* Esteban MARTINEZ
* Benjamin GELINEAU
* Hugo JOYET

## Prérequis

* [WAMP](https://www.wampserver.com)
* Base de données MySQL (avec PhpMyAdmin inclu avec WAMP)
* [PHP](https://www.php.net/downloads)

## Le Forum

### Database

Notre site web en php est accompagné d'une base de données dans laquelle sont classés tous les utilisateurs et tous les articles.<br>
Elle possède deux tables :

> **1. USER** : 
> - **id** *(id de l'utilisateur)*
> - **username** *(pseudo de l'utilisateur)*
> - **password** *(mot de passe crypté de l'utilisateur)*
> - **email** *(mail de l'utilisateur)*
> - **creationDate** *(date de création du compte)*
> - **pp** *(chemin d'accès à la photo de profil)*

> **2. ARTICLES**
> - **articleId** *(id du post)*
> - **title** *(titre du post)*
> - **description** *(contenu du post)*
> - **date** *(date de création du post)*
> - **userId** *(id de l'utilisateur qui a créer le post)*


### Structure du site

Le site est composé de plusieurs pages, il y a en premier la page `Home` où les articles sont classés selon leur date de publication. 

![](https://i.imgur.com/zAOHlg5.png)


Il y a une page `Login` et une page `Register` qui permettent à l'utilisateur de créer un compte et de s'y connecter.

![](https://i.imgur.com/eXYioV2.png)

![](https://i.imgur.com/nEbbsy9.png)


Une page `New` vous permettra d'écrire un nouvel un nouvel article, et vous retrouverez les details d'un article sur la page `Details`. Il y a également une page `Edit` pour modifier votre article.

![](https://i.imgur.com/dsBB7cF.png)

![](https://i.imgur.com/11trXXL.png)


Il y a une page `Account` pour afficher les information du compte et pour les modifier.

![](https://i.imgur.com/kvRlxjR.png)

## Accéder au forum

1. Lancez **wamp**<br>
    <details>
    <summary><b>Si vous n'avez pas la base de données</b></summary>
    <br>
    <ol>
        <li>Accédez à <a href="http://localhost/phpmyadmin/index.php">PhpMyAdmin</a>,
        <li>Créez une <b>nouvelle base de données</b>,
        <li>Une fois sélectionnée, allez dans l'onglet <b>SQL</b>,
        <li>Écrivez les reqêtes suivantes :
        <pre>
        DROP TABLE IF EXISTS `articles`;
        CREATE TABLE IF NOT EXISTS `articles` (
            `articleId` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(70) NOT NULL,
            `description` varchar(255) NOT NULL,
            `date` date NOT NULL,
            `userId` int(11) NOT NULL,
            PRIMARY KEY (`articleId`)
        )<br>
        DROP TABLE IF EXISTS `user`;
        CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(20) NOT NULL,
            `password` varchar(255) NOT NULL,
            `email` varchar(80) NOT NULL,
            `creationDate` date NOT NULL,
            `pp` varchar(2083) NOT NULL DEFAULT 'https://www.cournondanseattitude.fr/wp-content/uploads/2019/07/blank-profile-picture-973460_640.png',
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`),
            UNIQUE KEY `email` (`email`)
        );
    </details>
2. Dans un terminal **executez la commande** `php -S localhost:<port>`
3. Dans votre navigateur **allez sur l'URL suivante** : `localhost:<port>/login.php` afin de vous connecter.