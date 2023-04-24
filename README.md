# sales-api
Projeto em PHP para teste na SoftExpert

## Visão geral

O projeto se trata de uma aplicação para registrar vendas de um mercado. Temos cadastro de tipos de produtos, produtos e venda. Este módulo é uma API REST, desenvolvida utilizando PHP 8. Dada a proposta do projeto, não foi utilizada qualquer biblioteca que auxilie com roteamento, validações ou conexão com banco de dados.

## Configuração do ambiente

### Requisitos

Para executar esta API, é necessário ter instalado: 

* PHP 8.0 ou superior
* PostgreSQL 15.2
* Composer

### Instalação

Com o PHP e o Composer instalados, é necessário rodar o seguinte comando:


```
composer dumpautoload
```


Para subir a API, podemos utilizar o servido embutido do PHP:

```
php -S localhost:8080 -t public
```

É necessário se atentar ao parâmetro -t, o arquivo index.php, se encontra no diretório public.

### Configuração

#### Backup da base de dados
Deixo em anexo um backup da base de dados utilizada no projeto, mas no diretório database, estão os scripts para criação das estruturas da base de dados.

##### Restaurando o backup
O primeiro passo será a criação da base de dados para restaurar o backup:

```
createdb -U [usuário] -h [host] -p [porta] [nome_da_nova_base_de_dados]
```

Feito isso, o próximo passo será a restauração:

```
psql -U [usuário] -h [host] -p [port] [nova_base_de_dados] < [caminho_do_arquivo_backup.sql]
```

Feito isso, basta seguir para a configuração da conexão com o banco no próximo item.

#### Configuração da conexão com o banco
Dentro do diretório config, temos um arquivo, database.php, nele ficam as configurações da conexão com o banco de dados. 

#### Docker-compose
Opcionalmente, existe um arquivo docker-composer.json, configurado para subir um servidor de banco de dados PostgreSQL.

### Endpoints
A API possui os seguintes endpoints:

#### GET /product-types
Retorna uma lista com todos os tipos de produtos cadastrados.

#### GET /product-types/{id}
Retorna um tipo de produto, referente ao ID passado na rota.

#### POST /product-types 
Cadastra um novo tipo de produto e retorna o novo produto.
Deve ser enviado um JSON com as seguintes informações no corpo da requisição:

* name: nome do tipo de produto, campo único no banco de dados. Obrigatório.
* taxPercentage: percentual de imposto aplicado sobre o tipo de produto, campo numérico. Obrigatório.

#### PUT /product-types/{id}
Altera um registro no banco de dados, referente ao ID passado na rota. Deve ser enviado um JSON com as seguintes informações no corpo da requisição:

* name: nome do tipo de produto, campo único no banco de dados. Obrigatório.
* taxPercentage: percentual de imposto aplicado sobre o tipo de produto, campo numérico. Obrigatório.

#### DELETE /product-types/{id}
Remove um registro do banco de dados, referente ao ID passado na rota.


#### GET /products
Retorna uma lista com todos os produtos e seus tipos.

#### GET /products/{id}
Retorna um produto, referente ao ID passado na rota.

#### POST /products 
Cadastra um novo produto e retorna o novo produto.
Deve ser enviado um JSON com as seguintes informações no corpo da requisição:

* name: nome do tipo de produto. Obrigatório.
* barcode: código de barras do produto, campo  único no banco de dados. Obrigatório.
* description: Descrição breve sobre o tipo de produto. Opcional.
* price: preço unitário do produto. Obrigatório.
* productType->id: Se atentar à estrutura: (productType: id: 12), campo referente ao tipo de produto.


#### PUT /products/{id}
Altera um registro no banco de dados, referente ao ID passado na rota. Deve ser enviado um JSON com as seguintes informações no corpo da requisição:

* name: nome do tipo de produto. Obrigatório.
* barcode: código de barras do produto, campo  único no banco de dados. Obrigatório.
* description: Descrição breve sobre o tipo de produto. Opcional.
* price: preço unitário do produto. Obrigatório.
* productType->id: Se atentar à estrutura: (productType: id: 12), campo referente ao tipo de produto.

#### DELETE /products/{id}
Remove um registro do banco de dados, referente ao ID passado na rota.

#### GET /sales
Retorna uma lista com todas as vendas, seus itens, produtos e tipos.

#### POST /sales 
Cadastra uma nova venda.
Deve ser enviado um JSON com as seguintes informações no corpo da requisição:

* array de objetos com a seguinte estrutura:
* product->id: se atentar à estrutura: (product: id: 1), campo referente ao produto sendo vendido. Obrigatório.
* soldAmount: quantidade do produto que foi vendida. Através desses dois campos, conseguimos calcular qual o valor da compra e dos impostos.

# Considerações finais
Esta API foi desenvolvida como parte de um projeto de mercado e pode ser usada como base para outras aplicações similares. Se tiver alguma dúvida ou sugestão, por favor, não hesite em entrar em contato conosco.




