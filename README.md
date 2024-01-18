# API de Gerenciamento de Clientes

A API de Gerenciamento de Clientes é um projeto desenvolvido para gerenciar informações sobre clientes. O sistema
oferece funcionalidades como listar todos os clientes cadastrados e buscar detalhes específicos de um cliente por meio
de sua identificação (ID).

## Pré-requisitos

- PHP 5.3
- MySQL 5.5
- Docker
## Funcionalidades

### Listar Clientes

- Endpoint: `http://localhost/api/clientes/lista`
- Descrição: Retorna uma lista com todos os clientes cadastrados no sistema.

### Buscar Cliente por ID

- Endpoint: `http://localhost/api/clientes/buscar?id={ID}`
- Descrição: Retorna informações detalhadas de um cliente específico com base no seu ID.

## Configuração do Ambiente com Docker

Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

### Passos para Configuração:

1. Clone este repositório:
   ```bash
    git clone https://github.com/salatielfiore/api-php-poo.git
    ```
2. Navegue até o diretório do projeto:
   ```bash
    cd api-php-poo
    ```
3. Execute o Docker Compose para subir os serviços PHP e MySQL:
    ```bash
    docker-compose up -d
   ```
4. Crie a tabela necessária no MySQL usando PHPMyAdmin ou outro cliente MySQL.
    ```sql
    CREATE TABLE api.clientes (
        id BIGINT auto_increment NOT NULL,
        nome varchar(100) NULL,
        telefone varchar(100) NULL,
        CONSTRAINT contatos_PK PRIMARY KEY (id)
    )
    ENGINE=InnoDB
    DEFAULT CHARSET=latin1
    COLLATE=latin1_swedish_ci;
   ```
5. A aplicação estará disponível em http://localhost/api/.
6. Parando os Serviços Docker
    ```bash
    docker-compose down
   ```