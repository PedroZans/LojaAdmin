# API de Gerenciamento de Loja

## Requisitos
- PHP 8.0+
- Composer
- MySQL

## Instalação
1. `composer install`
2. Copie `.env.example` para `.env`
3. Configure as variáveis de banco de dados
4. `php artisan key:generate`
5. `php artisan migrate`


### Produtos
- GET `/api/v1/produtos` - Lista todos
- POST `/api/V1/produtos` - Cria novo
- GET `/api/v1/produtos/{id}` - Mostra específico
- PUT `/api/v1/produtos/{produtos}` - Atualiza
- DELETE `/api/v1/produtos/{id}` - Remove

### IBGE Integração
- GET `/api/ibge/municipios-rj` - Busca municípios do RJ na API do IBGE
- GET `/api/ibge/municipios` - cadastra o ID e Nome dos municípios do IBGE na base de dados 

## Testes
Para usar esta API deve-se usar o Postman, nele você vai conseguir listar todos os produtos, atualizar e deletar, também ira conseguir listar os municipios do Rio de Janeiro com base na API do IBGE, também tera como sicronizar a mesma para a base de dados.

Os produtos devem ser adicionados e manuseado manualmente usando metodos como:

PUT = Atualizar.
POST = Adicionar a tabela.
GET = Listar informação da base de dados ou da API do IBGE.
DELETE = Para Deletar o produto da lista (O produto não será deletado da base de dados e sim apenas da listagem).

Nesta API também está incluso um metodo do qual não permite que os dados da base de dados sejam duplicados, cada dado dever ser unico. também há o requerimento de Token para algumas operações.
