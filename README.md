# CodersWarsztaty_3

Contact book: create your own contact book. Add and manage contacts :) 

Website was created using:

- HTML
- CSS
- Bootstrap front-end framework
- OOP PHP
- Symfony2
- FOSUserBundle
- Doctrine 2 ORM, DQL
- Twig templates

Implemented features:

- registration
- user login and logout
- edit user profil
- user can add and delete contact
- user can create group of contacts and delete them
- user can edit contacts and add them:
    - Description
    - Address
    - Email address
    - Phone number
    - Group
- user can search contact in his contacts
- user see only his contacts and groups

Installation guide:

- download repository
- unpack zip file
- open command line and type: 'cd contacts' to browse board directory
- next at command line type: 'composer install' - provide database parameters when asked
- next at command line type: php app/console doctrine:database:create
- next at command line type: php app/console doctrine:schema:update --force
- next at command line type: php app/console server:start
- browse: http://localhost:8000 
