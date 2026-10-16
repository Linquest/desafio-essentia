# Ambiente local Magento

Ambiente Docker para preparar o Magento Open Source 2.4.8-p5
e instalar o módulo Essentia_StorePickup.

## Pré-requisitos

- Repositório clonado ou baixado.
- Docker em execução, com containers Linux e Docker Compose v2.
- Conexão com a internet para baixar imagens e dependências.
- Porta local 8082 disponível.
- Memória e espaço em disco disponíveis para Magento, PHP,
  MariaDB e OpenSearch.

O PHP, o Composer e as dependências do Magento são executados
dentro dos containers.

Este ambiente utiliza credenciais de exemplo para desenvolvimento local.
Somente o Nginx é publicado no computador, no endereço 127.0.0.1.
O banco e o OpenSearch ficam na rede interna do Docker.

Execute os comandos Docker deste guia na pasta `magento/ambiente`.
Se abrir outro terminal, retorne a essa pasta antes de continuar.
A partir da raiz do repositório, use `cd magento/ambiente`.

As etapas executadas dentro do container são indicadas separadamente.
Este ambiente utiliza reindexação manual e não configura tarefas cron.

## 1. Preparar os serviços

No terminal do computador, a partir da raiz do repositório:

```sh
cd magento/ambiente
docker compose config --quiet
docker compose up -d --build --wait --wait-timeout 240 db opensearch php
```

O primeiro comando Docker valida a configuração.
O segundo constrói a imagem PHP, inicia os serviços necessários
e aguarda o banco e o OpenSearch ficarem disponíveis.

O Nginx será iniciado depois que os arquivos do Magento existirem.

## 2. Baixar o Magento e suas dependências

Ainda no terminal do computador, prepare a permissão do volume
e abra um terminal dentro do container PHP:

```sh
docker compose exec --user root php chown www-data:www-data /var/www/html
docker compose exec --user www-data php bash
```

Agora o terminal está dentro do container, na pasta `/var/www/html`.

Os comandos desta seção e das seções 3 e 4 devem ser executados
nesse terminal.

Em uma primeira instalação, essa pasta deve estar vazia.
Baixe a versão utilizada pelo projeto:

```sh
git clone --depth 1 --branch 2.4.8-p5 https://github.com/magento/magento2.git /var/www/html
```

Instale as dependências usando o arquivo de versões do Magento:

```sh
export COMPOSER_HOME=/tmp/composer
composer install --no-dev --prefer-dist --no-interaction
php bin/magento --version
```

A versão esperada é `Magento CLI 2.4.8-p5`.

Utilize `composer install`, preservando o `composer.lock`.
Não é necessário atualizar as dependências para instalar este projeto.

## 3. Instalar o Magento

Dentro do container PHP, execute:

```sh
php bin/magento setup:install \
  --base-url=http://127.0.0.1:8082/ \
  --db-host=db \
  --db-name=magento \
  --db-user=magento \
  --db-password=magento_local \
  --backend-frontname=admin \
  --admin-firstname=Admin \
  --admin-lastname=Local \
  --admin-email=admin@example.com \
  --admin-user=admin \
  --admin-password='EssentiaLocal2026!' \
  --language=pt_BR \
  --currency=BRL \
  --timezone=America/Sao_Paulo \
  --use-rewrites=1 \
  --search-engine=opensearch \
  --opensearch-host=opensearch \
  --opensearch-port=9200 \
  --opensearch-index-prefix=essentia_local \
  --opensearch-enable-auth=0
```

Esse comando cria as tabelas, configura a loja e cria o usuário
administrativo informado nos parâmetros.

Ative o modo de desenvolvimento:

```sh
php bin/magento deploy:mode:set developer
```

## 4. Copiar e instalar o módulo

O Docker disponibiliza a pasta do módulo deste repositório
no caminho `/module-source`, somente para leitura.

Ainda dentro do container, copie seu conteúdo para o diretório
de módulos do Magento:

```sh
mkdir -p /var/www/html/app/code/Essentia/StorePickup
cp -R /module-source/. /var/www/html/app/code/Essentia/StorePickup/
ls /var/www/html/app/code/Essentia/StorePickup
```

A listagem deve conter `Model`, `etc`, `view`, `registration.php`
e `README.md`.

Habilite o módulo e atualize o Magento:

```sh
php bin/magento module:enable Essentia_StorePickup
php bin/magento setup:upgrade
php bin/magento cache:clean config layout block_html full_page
php bin/magento module:status Essentia_StorePickup
```

O último comando deve informar que o módulo está habilitado.

Os arquivos foram copiados. Caso o código do módulo seja alterado
no repositório posteriormente, a cópia deverá ser atualizada também.

Para retornar ao terminal do computador:

```sh
exit
```

## 5. Abrir a aplicação

De volta ao terminal do computador, na pasta `magento/ambiente`:

```sh
docker compose up -d web
docker compose ps
```

- Loja: http://127.0.0.1:8082/
- Administração: http://127.0.0.1:8082/admin/
- Usuário: `admin`
- Senha: `EssentiaLocal2026!`

Use o endereço `127.0.0.1` configurado durante a instalação.

O Magento e o módulo já estão instalados.
A loja começa sem produtos e sem pedidos.

Continue na seção
[Validação manual realizada](../Essentia/StorePickup/README.md#validação-manual-realizada)
do README do módulo.

## Uso após a primeira instalação

Na pasta `magento/ambiente`, para parar os serviços:

```sh
docker compose stop
```

Para iniciá-los novamente:

```sh
docker compose up -d
```

Os volumes preservam os arquivos do Magento, os dados do banco
e os índices de busca. A instalação inicial não precisa ser repetida.
