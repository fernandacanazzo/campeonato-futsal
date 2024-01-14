##Ambiente:

Servidor XAMPP (PHP 8.2 + 10.9.8-MariaDB)

##App:

Laravel 10 REST API + Vue 3 (http://localhost:8000)

- M�todo Autoriza��o: Laravel Sanctum
1. Acesso APP via web: Sess�o/Cookie
2. Acesso endpoints API via client: Bearer token

- P�ginas:
1. Tela inicial login (/login)
2. Home/Classifica��o (/)
![alt text](https://github.com/fernandacanazzo/campeonato-futsal/blob/main/home_pagina.png?raw=true)
3. CRUD Partidas (/partidas)
![alt text](https://github.com/fernandacanazzo/campeonato-futsal/blob/main/partidas_pagina.png?raw=true)
4. CRUD Jogadores (/jogadores)
5. CRUD Times (/times)

##API:

Autentica��o (params email + password):
- POST api/login: retorna access token para acesso dos demais endpoints;

Classifica��o
- GET api/: lista;


Jogadores

- GET api/jogadores: lista;
- POST api/jogadores: cria novo;
- PATCH api/jogador/{id}: atualiza;
- DELETE api/jogador/{id}: deleta;


Times

- GET api/times: lista;
- POST api/times: cria novo;
- PATCH api/time/{id}: atualiza;
- DELETE api/time/{id}: deleta;


Partidas

- GET api/partidas: lista;
- POST api/partidas: cria nova;
- PATCH api/partida/{id}: atualiza;
- DELETE api/partida/{id}: deleta;
