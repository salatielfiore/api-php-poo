# API de Gerenciamento de Clientes

A API de Gerenciamento de Clientes é um projeto desenvolvido para gerenciar informações sobre clientes. O sistema
oferece funcionalidades como listar todos os clientes cadastrados e buscar detalhes específicos de um cliente por meio
de sua identificação (ID).

## Pré-requisitos

- PHP 5.3
- MySQL 5.5
- Docker

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
   
    CREATE TABLE api.usuario (
        id BIGINT auto_increment NOT NULL,
        nome varchar(100) NULL,
        email varchar(100) NULL,
        ativo BOOL NULL,
        senha varchar(100) NULL,
        CONSTRAINT usuario_PK PRIMARY KEY (id)
    )
    ENGINE=InnoDB
    DEFAULT CHARSET=latin1
    COLLATE=latin1_swedish_ci;
   
    CREATE TABLE api.usuario_token (
        id BIGINT auto_increment NOT NULL,
        token varchar(255) NOT NULL,
        generatedAt DATETIME NOT NULL,
        ativo BOOL NOT NULL,
        expires_in INT NOT NULL,
        id_usuario BIGINT NOT NULL,
        CONSTRAINT usuario_token_PK PRIMARY KEY (id),
        CONSTRAINT usuario_token_FK FOREIGN KEY (id_usuario) REFERENCES api.usuario(id)
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

## Funcionalidades

### Listar Clientes

- method: GET
- Endpoint: `http://localhost/api/clientes/lista`
- Descrição: Retorna uma lista com todos os clientes cadastrados no sistema.

### Buscar Cliente por ID

- method: GET
- Endpoint: `http://localhost/api/clientes/buscar?id={ID}`
- Descrição: Retorna informações detalhadas de um cliente específico com base no seu ID.

### Salvar Cliente

- method: POST
- Endpoint: `http://localhost/api/clientes/salvar`
- Dados JSON de Exemplo
   ```json
   {
     "nome": "Nome do Cliente",
     "telefone": "1234567890"
   }
  ```
- Descrição: Salva o cliente na base de dados.

### Alterar Cliente

- method: PUT
- Endpoint: `http://localhost/api/clientes/editar/{ID}`
- Dados JSON de Exemplo
   ```json
   {
     "nome": "Nome do Cliente",
     "telefone": "1234567890"
   }
  ```
- Descrição: Altera o cliente na base de dados.

### Excluir Cliente

- method: DELETE
- Endpoint: `http://localhost/api/clientes/excluir/{ID}`
- Descrição: Exclui o cliente da base de dados.
-

Lembre-se de substituir {ID} nos endpoints pelos IDs reais dos clientes que você deseja buscar, alterar ou excluir.
