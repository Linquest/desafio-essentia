# Desafio Backend — Essentia Group

Sistema de cadastro de clientes desenvolvido em PHP com Laravel,
seguindo o padrão MVC, com persistência em PostgreSQL e upload
de fotos para armazenamento local.

## Funcionalidades

- Listagem paginada de clientes com miniatura da foto.
- Cadastro com nome, e-mail, telefone e foto.
- Edição dos dados, mantendo ou substituindo a foto.
- Exclusão com confirmação e remoção da foto correspondente.
- Validação dos dados e mensagens em português.
- E-mail único por cliente, normalizado para minúsculas.
- Prévia da foto no cadastro e na edição, antes de salvar.
- Formatação de telefones brasileiros no cadastro, na edição e na listagem.

## Tecnologias

- PHP 8.4 e Laravel 13.
- Blade para as páginas renderizadas no servidor.
- PostgreSQL 17.
- Docker Compose para executar a aplicação e o banco.
- Apache como servidor HTTP.
- JavaScript nativo para a prévia das fotos e CSS compartilhado entre as telas.

## Modelo relacional

O diagrama e o dicionário de dados estão disponíveis em
[Modelo relacional](docs/modelo-relacional.md).

## Pré-requisitos

- Docker em execução, com suporte a containers Linux e Docker Compose.
- Conexão com a internet para baixar imagens e dependências.
- Portas locais 8080 e 5433 disponíveis.

PHP, Composer e PostgreSQL são executados nos containers.

## Primeira instalação

Clone ou baixe o repositório e abra um terminal na raiz do projeto,
onde está o arquivo compose.yaml.

Execute os comandos abaixo em ordem, usando PowerShell no Windows
ou um shell Linux/macOS.

```sh
# Crie a configuração local da aplicação.
cp src/.env.example src/.env

# Construa a imagem com PHP, Apache e Composer.
docker compose build app

# Instale as dependências registradas no composer.lock.
docker compose run --rm --no-deps app composer install --no-interaction

# Gere a chave da aplicação.
docker compose run --rm --no-deps app php artisan key:generate

# Permita que o servidor grave logs, sessões, cache e fotos.
docker compose run --rm --no-deps app sh -c "chown -R www-data:www-data storage bootstrap/cache && chmod -R u+rwX storage bootstrap/cache"

# Inicie o PostgreSQL e aguarde o banco ficar saudável.
docker compose up -d --wait db

# Crie as tabelas usando as migrations.
docker compose run --rm --no-deps --user www-data app php artisan migrate

# Disponibilize as fotos pela pasta pública.
docker compose run --rm --no-deps app php artisan storage:link

# Inicie a aplicação.
docker compose up -d app
```

Confira os serviços:

```sh
docker compose ps
```

Acesse [http://localhost:8080](http://localhost:8080).

A listagem começa sem clientes. Utilize "Novo cliente" para cadastrar
o primeiro registro.

## Uso após a instalação

Para iniciar os serviços:

```sh
docker compose up -d
```

Para encerrar os serviços:

```sh
docker compose down
```

Os dados do PostgreSQL permanecem no volume postgres_data.
As dependências do Composer ficam no volume vendor_data.
As fotos são armazenadas em src/storage/app/public/customers.

A cópia do arquivo de configuração e a geração da chave fazem parte
da primeira instalação.

## Fotos

São aceitas imagens JPEG, PNG e WebP de até 2 MB,
com dimensões máximas de 4096 × 4096 pixels.

Na edição, deixar o campo de foto vazio mantém a imagem atual.
Ao substituir a foto ou excluir o cliente, a aplicação tenta remover
o arquivo anterior do armazenamento.
