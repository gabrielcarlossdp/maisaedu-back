## Arquitetura da API

A API foi projetada com foco na separação de responsabilidades e na utilização de boas práticas do Laravel.

Endereço da API = https://maisaedu-back-production.up.railway.app

### Controllers
* Validam os dados de entrada das requisições utilizando FormRequests.
* Delegam a lógica de negócio para os Services.
* Formatam a resposta da API utilizando API Resources.
* Registram logs de erros.
* Comentários usados na documentação da rota

### Services
* Contêm a lógica de negócio da aplicação.
* Interagem com o banco de dados para persistir ou recuperar dados.

### Traits
* Centralizam a lógica de busca, filtro, ordenação e paginação, promovendo reutilização de código.

### Banco de dados
* Utiliza o sistema de migrations para versionar as alterações no esquema do banco de dados.
* Emprega factories e seeders para facilitar a criação de dados de teste.

### Tradução
* Permite personalizar os textos retornados na API para diferentes idiomas.

### SoftDeletes
* Implementa a lógica de exclusão lógica de registros, evitando a remoção definitiva dos dados.

### Autenticação
* Fornece endpoints para login, registro, logout e informações do usuário.
* Protege rotas sensíveis da aplicação.

## Qualidade e Testes

* **Qualidade do código:** Utiliza ferramentas como Laravel Pint e Laravel Sanctum para garantir a qualidade e segurança do código.
* **Testes:** Emprega PHPUnit e Pest para escrever testes unitários e garantir a corretude da aplicação.

## Outras características

* **[Documentação](https://maisaedu-back-production.up.railway.app/api/documentation):** A API é documentada utilizando Swagger, facilitando a compreensão e o uso.
* **[Logs](https://maisaedu-back-production.up.railway.app/log-viewer):** Os logs de erros são centralizados e podem ser facilmente acessados para fins de depuração.
* **Deploy:** A aplicação é deployada na plataforma [Raiway](https://railway.app) e configurada para realizar builds automáticos e atualizações de banco de dados.

## Melhorias futuras

* **Exportação:** Implementar a exportação de dados dos alunos em formato de planilha.
* **Upload de imagens:** Permitir o upload de fotos de perfil dos alunos.

## Bibliotecas de terceiros
* [darkaonline/l5-swagger](https://github.com/DarkaOnLine/L5-Swagger) (Documentação)
* [opcodesio/log-viewer](https://github.com/opcodesio/log-viewer) (Visualização de Logs)
* [larastan/larastan](https://github.com/larastan/larastan) (Análise de qualidade do código)