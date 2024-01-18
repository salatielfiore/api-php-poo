# Sistema de Gerenciamento de Contatos

Este projeto é uma aplicação simples de gerenciamento de contatos utilizando PHP e MySQL.

## Pré-requisitos

- PHP 5.3
- MySQL 5.5
- Docker

## Configuração do Ambiente com Docker

Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

### Passos para Configuração:

1. Clone este repositório:
   ```bash
    git clone https://github.com/salatielfiore/desafio-php.git
    ```
2. Navegue até o diretório do projeto:
   ```bash
    cd desafio-php
    ```
3. Execute o Docker Compose para subir os serviços PHP e MySQL:
    ```bash
    docker-compose up -d
   ```
4. Crie a tabela necessária no MySQL usando PHPMyAdmin ou outro cliente MySQL.
    ```sql
    CREATE TABLE test.contatos (
        id BIGINT auto_increment NOT NULL,
        nome varchar(100) NULL,
        telefone varchar(100) NULL,
        email varchar(100) NULL,
        data_criacao DATE NOT NULL,
        logo varchar(100) NULL,
        CONSTRAINT contatos_PK PRIMARY KEY (id)
    )
    ENGINE=InnoDB
    DEFAULT CHARSET=latin1
    COLLATE=latin1_swedish_ci;
   ```
5. A aplicação estará disponível em http://localhost:8080/web/index.php.
6. Parando os Serviços Docker
    ```bash
    docker-compose down
   ```

## Estrutura do Projeto
* index.php: Página principal que exibe a lista de contatos.
* contato/views/tela_adicionar_contato.php: Página para adicionar um novo contato.
* contato/views/tela_editar_contato.php: Página para editar um contato existente.
* contato/scripts/excluir_contato.php: Script para excluir um contato do banco de dados.
* contato/scripts/listar_contato.php: Script para listar contatos do banco de dados.
- Esses são as funcionalidade principais ainda existe outras.

## Personalizações
* Para personalizar o número de contatos exibidos por página, utilize o seletor no canto inferior esquerdo.
* Você pode ordenar a lista de contatos clicando nos cabeçalhos das colunas.
* Use os campos de pesquisa para filtrar os contatos com base no nome, telefone, email e intervalo de datas.