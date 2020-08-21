Para que o projeto funcione é preciso criar um banco de dados chamado "povodeolho" e popula-lo apartir do comando: "php artisan db:seed" (caso necessite de senha para ter acesso ao banco de dados, modificar os campos "DB_USERNAME" e "DB_PASSWORD" no arquivo ".env" na raiz do projeto)


Notas:
    O projeto não está completo, não foi desenvolvida a parte que coleta os dados sobre as verbas indenizatórias e faz um top 5 dos deputados que mais fizeram uso delas. A parte que coleta os dados das redes socias está completa (arquivo da API: "RankingController.php").