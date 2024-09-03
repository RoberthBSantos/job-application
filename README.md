<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Visão Geral

Este projeto é uma aplicação Laravel configurada para rodar em um ambiente Docker. Inclui um servidor Nginx, um contêiner de aplicação PHP-FPM com Laravel, e um banco de dados MySQL. Este README irá guiá-lo através dos passos necessários para configurar e executar o projeto.

## Pré-requisitos

Certifique-se de que você tem o seguinte software instalado:

- **Docker**: [Instruções de instalação](https://docs.docker.com/get-docker/)
- **Docker Compose**: [Instruções de instalação](https://docs.docker.com/compose/install/)

## Configuração Inicial

1. **Clone o Repositório:**

   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. **Crie o arquivo `.env`:**

   Crie um arquivo `.env` na raiz do projeto e configure as variáveis de ambiente conforme necessário. Você pode usar o arquivo `.env.example` como base:

   ```bash
   cp .env.example .env
   ```

3. **Configure as Variáveis de Ambiente do Banco de Dados:**

   No arquivo `.env`, certifique-se de definir as seguintes variáveis:

   ```env
   MYSQL_ROOT_PASSWORD=senha_root
   MYSQL_DATABASE=nome_do_banco
   MYSQL_USER=usuario
   MYSQL_PASSWORD=senha
   ```

## Executando a Aplicação

1. **Construa e Inicie os Containers:**

   Execute o comando abaixo para construir e iniciar os containers:

   ```bash
   docker-compose up -d
   ```

   Isso irá iniciar os serviços definidos no `docker-compose.yml`:
   - Um container Nginx (`web`) para servir a aplicação.
   - Um container PHP-FPM (`app`) para executar o Laravel.
   - Um container MySQL (`db`) como banco de dados.

2. **Acesse a Aplicação:**

   Após os containers estarem em execução, acesse a aplicação via navegador:

   ```
   http://localhost
   ```

## Migrando e Populando o Banco de Dados

O banco de dados será automaticamente migrado e populado quando o Docker Compose iniciar, conforme definido no comando `command` do serviço `app`. Este comando executa:

```bash
php artisan migrate --force && php artisan db:seed --force
```

## Como Parar a Aplicação

Para parar todos os containers:

```bash
docker-compose down
```

## Seeds para Teste

Para testar a paginação e outras funcionalidades, seeds foram criados para adicionar 50 candidatos e 50 vagas automaticamente ao banco de dados.

## Debug e Logs

Caso você precise verificar logs ou informações de erro, utilize:

```bash
docker-compose logs
```

# API

## 🔑 Obtendo o Token de Autenticação

Para interagir com a API, você precisa primeiro obter um token de autenticação. O token pode ser gerado utilizando o endpoint de login da API.

### Rota para Autenticação

```http
POST /api/tokens/create
```

### Exemplo de Requisição para Obter o Token

```bash
curl -X POST http://localhost/api/tokens/create \
-H "Content-Type: application/json" \
-d '{"email": "admin@example.com", "password": "password"}'
```

A resposta será um token JWT que deve ser usado nas requisições subsequentes para autenticação. Inclua o token no cabeçalho `Authorization` de cada requisição da seguinte forma:

```
Authorization: Bearer {YOUR_API_TOKEN}
```

### Usuário Padrão Criado pelo Docker

Quando a aplicação é configurada e iniciada com o Docker, um usuário padrão é automaticamente criado no banco de dados:

- **Email:** `admin@example.com`
- **Senha:** `password`

Use estas credenciais para fazer login e obter o token de autenticação.


## API Endpoints

A aplicação expõe uma API RESTful para gerenciar candidatos e vagas de emprego. Abaixo estão os principais endpoints e exemplos de como realizar requisições utilizando cURL.

### Autenticação

Todas as requisições da API devem ser autenticadas usando um token de API. Adicione o token ao header da requisição como `Authorization: Bearer {YOUR_API_TOKEN}`.

### Endpoints de Candidatos

#### Listar Candidatos:

```bash
curl -X GET http://localhost/api/candidates -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

#### Criar um Novo Candidato:

```bash
curl -X POST http://localhost/api/candidates \
-H "Authorization: Bearer {YOUR_API_TOKEN}" \
-H "Content-Type: application/json" \
-d '{"name": "John Doe", "email": "john.doe@example.com", "phone": "123456789", "address": "123 Street, City"}'
```

#### Mostrar um Candidato Específico:

```bash
curl -X GET http://localhost/api/candidates/{id} -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

#### Atualizar um Candidato:

```bash
curl -X PUT http://localhost/api/candidates/{id} \
-H "Authorization: Bearer {YOUR_API_TOKEN}" \
-H "Content-Type: application/json" \
-d '{"name": "Jane Doe", "email": "jane.doe@example.com"}'
```

#### Excluir um Candidato:

```bash
curl -X DELETE http://localhost/api/candidates/{id} -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

#### Inscrever um Candidato em Vagas:

```bash
curl -X POST http://localhost/api/candidates/{id}/apply \
-H "Authorization: Bearer {YOUR_API_TOKEN}" \
-H "Content-Type: application/json" \
-d '{"job_ids": [1, 2, 3]}'
```

### Endpoints de Vagas

#### Listar Vagas:

```bash
curl -X GET http://localhost/api/jobs -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

#### Criar uma Nova Vaga:

```bash
curl -X POST http://localhost/api/jobs \
-H "Authorization: Bearer {YOUR_API_TOKEN}" \
-H "Content-Type: application/json" \
-d '{"title": "Desenvolvedor Backend","type": "CLT","paused": false}'
```

#### Mostrar uma Vaga Específica:

```bash
curl -X GET http://localhost/api/jobs/{id} -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

#### Atualizar uma Vaga:

```bash
curl -X PUT http://localhost/api/jobs/{id} \
-H "Authorization: Bearer {YOUR_API_TOKEN}" \
-H "Content-Type: application/json" \
-d '{"title": "Desenvolvedor Full Stack", "salary": 6000}'
```

#### Excluir uma Vaga:

```bash
curl -X DELETE http://localhost/api/jobs/{id} -H "Authorization: Bearer {YOUR_API_TOKEN}"
```

### Observação

Substitua `{id}` pelo ID do candidato ou da vaga que deseja manipular, e `{YOUR_API_TOKEN}` pelo token de autenticação gerado para o usuário autenticado.
