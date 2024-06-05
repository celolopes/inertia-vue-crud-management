# CRUD de Gerenciamento de Alunos e Regras de Acesso

Este projeto é uma aplicação CRUD para gerenciamento de cadastro de alunos e de regras de perfis de acesso. O projeto foi desenvolvido utilizando InertiaJS e Vue3 com Laravel 11.

## Requisitos

- PHP >= 8.1
- Composer
- Node.js >= 14.x
- NPM
- Herd (para configurar a URL do projeto)

## Passo a Passo para Configuração

### 1. Clone o Repositório

```
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio
```
### 2. Instale as Dependências do PHP
```
composer install
```
### 3. Instale as Dependências do Node.js
```
npm install
```
### 4. Configure o Arquivo .env
Renomeie o arquivo .env.example para .env e configure as variáveis de ambiente conforme necessário. Como o banco de dados utilizado é SQLite, certifique-se de que a configuração do banco de dados no arquivo .env esteja assim:
```
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/para/sua/base_de_dados.sqlite
```
### 5. Gere a Chave da Aplicação
```
php artisan key:generate
```
### 6. Execute as Migrações e Seeders
```
php artisan migrate --seed
```
### 7. Compile os Assets
```
npm run dev
```
### 8. Instale e Configure o Herd
Herd é uma ferramenta para gerenciar servidores locais. Siga as instruções abaixo para instalá-lo e configurá-lo:

### Instalação do Herd:

Baixe e instale o Herd a partir do site oficial.
Siga as instruções de instalação específicas para o seu sistema operacional.
Configuração do Herd:

### Configure a URL do projeto no Herd:
```
herd link http://inertia-vue-crud-management.test
```
### Inicie o servidor do Herd:
```
herd start
```
### 9. Acesse a Aplicação
Abra o navegador e acesse a URL configurada:

```
http://inertia-vue-crud-management.test
```
## Estrutura do Projeto

Frontend: InertiaJS e Vue3
Backend: Laravel 11
Banco de Dados: SQLite

## Funcionalidades

### Gerenciamento de Alunos:
Criar, Ler, Atualizar e Excluir alunos.
### Gerenciamento de Regras de Acesso:
Criar, Ler, Atualizar e Excluir regras de acesso para diferentes perfis de usuário.

## Contribuição

Se você deseja contribuir para este projeto, por favor siga as diretrizes de contribuição e envie um Pull Request.

## Licença

Este projeto está licenciado sob a MIT License.

Se você tiver qualquer dúvida ou problema, sinta-se à vontade para abrir uma issue ou entrar em contato.
