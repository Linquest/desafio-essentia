# Essentia_StorePickup — Retirado na Loja

Módulo de entrega para Magento 2 que oferece retirada na loja com
preço e custo zero, sem consultar serviços externos de frete.

## Ambiente validado

- Magento Open Source 2.4.8-p5.
- PHP 8.4.
- Modo de execução: developer.

## Instalação

Para preparar um Magento do zero com Docker, siga o
[guia do ambiente local](../../ambiente/README.md), que também
inclui a cópia e a instalação deste módulo.

As instruções abaixo são para uma instalação Magento já funcional,
com suas dependências e banco de dados configurados.

O módulo foi validado no Magento Open Source 2.4.8-p5, com PHP 8.4,
em modo developer. A compatibilidade com outras versões não foi verificada.

1. Copie a pasta `magento/Essentia/StorePickup` deste repositório
   para `app/code/Essentia/StorePickup` na instalação Magento.

2. Na raiz do Magento, onde está `bin/magento`, execute os comandos
   com o PHP do ambiente e o usuário responsável pelos arquivos:

```sh
php bin/magento module:enable Essentia_StorePickup
php bin/magento setup:upgrade
php bin/magento cache:clean config layout block_html full_page
php bin/magento module:status Essentia_StorePickup
```

O último comando deve informar que o módulo está habilitado.

Em modo `production`, inclua `php bin/magento setup:di:compile`
após `setup:upgrade` e antes da limpeza de cache. A validação
deste projeto foi realizada em modo `developer`.

## Comportamento

O módulo fica ativo por padrão. A ativação e os nomes exibidos
são definidos em `etc/config.xml`. O preço e o custo da entrega
são fixados em zero na classe `Model/Carrier/StorePickup.php`.

- Grupo de entrega: **Retirado na Loja**.
- Método: **Retirada gratuita**.
- Preço cobrado do cliente: **zero**.
- Custo interno da entrega: **zero**.

A descrição da entrega é salva pelo Magento no pedido e exibida
nos detalhes administrativos.

Na grade de pedidos, o módulo torna visível a coluna nativa
**Shipping Information**, preservando seu filtro de texto.

Preferências de visualização salvas pelo administrador podem
manter a coluna oculta. Nesse caso, selecione-a no menu **Columns**.

## Validação manual realizada

1. Cadastrar um produto físico habilitado, visível e com estoque.
2. Adicioná-lo ao carrinho e preencher os dados do checkout.
3. Selecionar **Retirado na Loja / Retirada gratuita** e conferir
   o frete zero.
4. Finalizar o pedido com o pagamento offline **Check / Money order**.
5. Em **Sales → Orders**, abrir o pedido e conferir a descrição
   da entrega, o frete zero e o total.
6. Na grade, filtrar **Shipping Information** por `Retirado na Loja`
   e conferir a presença do pedido.
7. Substituir o filtro por `inexistente` e conferir que nenhum
   pedido aparece. Remover o filtro ao final.

Se um produto recém-cadastrado não aparecer na busca devido a
índices pendentes, execute:

```sh
php bin/magento indexer:reindex
```

## Decisões de implementação

- Carrier próprio baseado em `AbstractCarrier` e `CarrierInterface`.
- Dependências recebidas por injeção no construtor.
- Uso das APIs nativas para oferecer a entrega ao checkout.
- Persistência da entrega pelo fluxo padrão de pedidos do Magento.
- Extensão da grade por XML, reutilizando coluna e filtro existentes.
- Nenhuma alteração no código interno da plataforma ou criação
  de tabelas para este módulo.
