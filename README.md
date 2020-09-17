## Dependências 
Node, npm, composer, mysql, php 7.3


## Passo a Passo instalação 

1º git clone  https://github.com/laiquesantana/LaravelTest.git  

2º Abrir o terminal na pasta do projeto clonado.

3º rodar o comando "Composer install" para instalar as dependências do php.

4º rodar o comando "npm install && npm run dev" para instalar as dependências e pacote do VueJs

5º atualizar no arquivo .env as credencias do MySql DB_DATABASE,DB_USERNAME, DB_PASSWORD, com um nome para a database( criar no mysql uma database com o nome desejado e atualizar no env), o nome do usuário e a senha do mysql respectivamente.

6º rodar o seguinte comando  no terminal ./scripts/migrateAndSeeder, para criar as tabelas no banco através de migrations configurar o acesso 
a API com o laravel passaport e rodar os seeds para popular a tabela de produtos.

7º php artisan server

8º Acessar http://localhost:8000

9º Navegar menu lateral para "List of Products"


## testes

1º rodar o comando php artisan test 