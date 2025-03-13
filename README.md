# API Laravel - Projeto VLab

## 📌 Sobre o Projeto

Este projeto consiste em uma API desenvolvida com Laravel para monitoramento financeiro. Ele inclui um modelo relacional de banco de dados, migrations, rotas API e documentação Swagger. Foi desenvolvido a partir de um projeto de um processo seletivo da empresa V-Lab da UFPE, as quais especificações com user stories se encontra no arquivo Seleção VLAB - Back-end.pdf

## 🏗️ Estrutura do Banco de Dados

A API utiliza um banco de dados relacional, o qual foi modelado através da ferramenta [EERCASE](https://sites.google.com/a/cin.ufpe.br/eercase/), contendo as seguintes tabelas principais:

### 🔹 Tabelas

1. **usuarios**

   - `CPF` (PK)
   - `nome`
   - `email`
   - `senha`
   - `data_cadastro`

2. **categorias** (Categorias de Despesas/Receitas)

   - `id` (PK)
   - `nome`

3.**transacoes**

   - `id` (PK)
   - `cpf_usuario` (FK -> usuarios)
   - `valor`
   - `tipo` ("Recebeu" ou "Pagou")
   - `id_categoria` (FK -> categorias)
   - `data`
     
### 🔹 Relacionamentos

- Um **usuário** pode ter **múltiplas transações**.
- Cada **transação** está associada a um **usuário** e uma **categoria**.

## 🚀 Migrations

O banco de dados é construído e atualizado com migrations. Aqui estão os comandos para criar as tabelas:

```sh
php artisan migrate
```

Caso precise resetar o banco de dados e popular com dados de teste (seeds):

```sh
php artisan migrate:fresh --seed
```

## 🛠️ Rotas da API

A API expõe os seguintes endpoints:

## Usuários

| **Método** | **Rota**                      | **Descrição**                               |
|------------|--------------------------------|---------------------------------------------|
| `GET`      | `/api/usuarios`               | Lista todos os usuários                     |
| `GET`      | `/api/usuarios/{id}`          | Retorna os detalhes de um usuário por **CPF** |
| `POST`     | `/api/usuarios/criar`         | Cadastra um novo usuário                    |
| `PUT`      | `/api/usuarios/atualizar/{id}`| Atualiza dados de um usuário por **CPF**    |
| `DELETE`   | `/api/usuarios/deletar/{id}`  | Deleta um usuário por **CPF**               |

---

## Transações

| **Método** | **Rota**                                   | **Descrição**                                      |
|------------|-------------------------------------------|----------------------------------------------------|
| `GET`      | `/api/transacoes`                        | Lista todas as transações                          |
| `GET`      | `/api/transacoes/{id}`                   | Retorna os detalhes de uma transação por **ID**             |
| `GET`      | `/api/transacoes/usuario/{usuario}`      | Lista todas as transações por **CPF do usuário**  |
| `GET`      | `/api/transacoes/categoria/{categoria}`  | Lista todas as transações por **ID da categoria** |
| `GET`      | `/api/transacoes/tipo/{tipo}`           | Lista todas as transações por **tipo**            |
| `POST`     | `/api/transacoes/criar`                  | Cria uma nova transação                           |
| `DELETE`   | `/api/transacoes/deletar/{id}`           | Exclui uma transação por **ID**                             |

---

## Categorias

| **Método** | **Rota**                         | **Descrição**                        |
|------------|---------------------------------|--------------------------------------|
| `GET`      | `/api/categorias`              | Lista todas as categorias           |
| `GET`      | `/api/categorias/{id}`         | Retorna os detalhes de uma categoria por **ID** |
| `POST`     | `/api/categorias/criar`        | Cria uma nova categoria             |
| `DELETE`   | `/api/categorias/deletar/{id}` | Exclui uma categoria por **ID**         |

---

## 📖 Documentação Swagger

A API possui documentação gerada pelo Swagger. Para acessá-la, utilize:

```sh
php artisan l5-swagger:generate
```

E acesse a documentação no navegador:

```
http://localhost:8000/api/documentation
```

## 🔧 Instalação e Configuração

1. Clone o repositório:
   ```sh
   git clone https://github.com/roboberto1403/api_lavarel.git
   cd api_lavarel
   ```
2. Instale as dependências:
   ```sh
   composer install
   ```
3. Copie o arquivo de ambiente:
   ```sh
   cp .env.example .env
   ```
4. Gere a chave da aplicação:
   ```sh
   php artisan key:generate
   ```
5. Configure o banco de dados no `.env`
6. Rode as migrations:
   ```sh
   php artisan migrate --seed
   ```
7. Inicie o servidor:
   ```sh
   php artisan serve
   ```

Agora, a API estará rodando em `http://localhost:8000`.


## 📝 Licença

Este projeto está sob a licença [MIT license](https://opensource.org/licenses/MIT).

---

**Desenvolvido com Laravel** 
