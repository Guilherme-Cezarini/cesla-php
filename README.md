
# Cesla PHP

Este repositório contém um projeto exemplo que utiliza Composer para gerenciamento de dependências, Docker para containerização e Doctrine Migrations para gerenciamento de migrações de banco de dados. Abaixo estão os passos necessários para configurar e executar o projeto.

## Pré-requisitos

Antes de começar, certifique-se de que você tem os seguintes softwares instalados em sua máquina:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [Apache](https://httpd.apache.org/docs/2.4/install.html)
- PHP 8.4.*

## Configuração do Projeto

Siga os passos abaixo para configurar e executar o projeto:
### Passo 1: Copiar o .env.example

Primeiro, copie o .env.example para um .env e coloque as variáveis necessárias, sem ela o projeto nao sobe!

### Passo 2: Instalar Dependências com Composer

Segundo, instale as dependências do projeto usando o Composer. Execute o seguinte comando na raiz do projeto:

```bash
composer install
```

Este comando irá baixar todas as dependências necessárias listadas no arquivo `composer.json`.

### Passo 3: Iniciar os Containers com Docker Compose

Em seguida, inicie os containers Docker usando o Docker Compose. Execute o seguinte comando:

```bash
docker compose up -d
```

Este comando irá construir e iniciar os containers definidos no arquivo `docker-compose.yml`. A opção `-d` executa os containers em segundo plano.

### Passo 4: Executar Migrações do Banco de Dados

Após os containers estarem em execução, você precisa aplicar as migrações do banco de dados. Execute o seguinte comando:

```bash
./vendor/bin/doctrine-migrations migrations:migrate
```

Este comando irá aplicar todas as migrações pendentes ao banco de dados, criando ou atualizando as tabelas conforme necessário.

### Passo 5: Rodando a aplicação

Para subir o projeto é necessario ir na pasta root do projeto e rodar: 

```bash
php -S localhost:8080 -t public
```

### Passo 6: Dar Permissão de Execução ao Arquivo `cli.php`

Por fim, dê permissão de execução ao arquivo `cli.php` para que você possa executar comandos através dele. Execute o seguinte comando:

```bash
chmod +x cli.php
```

Agora você pode executar comandos usando o arquivo `cli.php`.

## Executando Comandos

Para executar comandos, use o seguinte formato:

```bash
./cli.php <command>
```

Substitua `<command>` pelo comando que você deseja executar.

## Exemplos de Uso

Aqui estão alguns exemplos de como você pode usar o `cli.php`:

```bash
./cli.php list
./cli.php help
./cli.php <nome-do-comando> [opções]
```

## Contato

Se você tiver alguma dúvida ou sugestão, sinta-se à vontade para entrar em contato:

- **Nome**: [Guilherme Cezarini]
- **Email**: [cezarini.guilherme2@gmail.com]
- **GitHub**: [Guilherme-Cezarini]

