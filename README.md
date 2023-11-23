﻿# POLP

Aplicativo financeiro para controlar gastos de sua casa de forma simples. Dizendo o quanto devo e quanto tenho e o
sistema te dará as perpectivas que precisa.

## Instalação

### Requisitos

1. PHP 8.2+
2. Composer lasted
3. NPM
3. MySQL ou MariaDB
4. Vuecli

### Passos de Instalação

1. **Clone o repositório**
   ```bash
   git clone git@github.com:luanmarcosfgns/financeiro.git

2. **Abra o terminal e digite comando para instalar:**
   ```bash
   cd financeiro/backend && composer install && cd .. && cd frontend && npm install

3. **Agora Configure o backend acessando o diretório pasta financeiro/backend do projeto, renomeando o arquivo
   env.example para env e colocando suas credenciais**
   ```bash
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=financeiro
       DB_USERNAME=root
       DB_PASSWORD=root
5. **Suba o banco de dados**
   ```bash 
     php artisan migrate
6. **Para gerar a chave secreta do JWT digite**
   ```bash 
     php artisan jwt:secret  

8. **Para iniciar o serve digite**
   ```bash 
     php artisan serve --host=api.localhost
9. **E ele será iniciado na porta 8000 então host será api.localhost:8000**

10. **Agorá abra um novo terminal vá ao frontend no diretório /financeiro/fontend e configure o arquivo .env**

   ```bash 
   VUE_APP_HOST_NAME="http://app.localhost:8080"
   VUE_APP_API_HOST_NAME="http://api.localhost:8000"
   VUE_APP_APPLICATION_NAME="POLP"
11. **Logo depois digite o comando para iniciar o servidor **

```bash 
   npm run serve