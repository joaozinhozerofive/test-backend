# Sistema de Contatos - Magazord

Sistema de gerenciamento de pessoas e contatos desenvolvido em PHP, seguindo o padrão MVC e utilizando Doctrine ORM e PostgreSQL.

## Requisitos

- Docker Desktop instalado
- Para utilizar o Docker, você deverá instalar um serviço Linux caso esteja utilizando Windows
- WSL instalado: https://learn.microsoft.com/windows/wsl/install

## Instalação e Execução

1. Clone o repositório em alguma pasta:
```bash
git clone https://github.com/joaozinhozerofive/test-backend.git
cd test-backend
```

2. Execute com Docker Composee instale as dependências:
```bash
docker-compose up -d --build
docker-compose exec web composer install
```

## Banco de Dados

O sistema utiliza PostgreSQL com as seguintes tabelas:

- **persons**: Armazena dados das pessoas (nome, CPF)
- **contacts**: Armazena contatos das pessoas (tipo, descrição, pessoa_id)

### Executar Migrations (criar tabelas no banco de dados)

```bash
docker-compose exec web php migrations.php status

docker-compose exec web php migrations.php migrate

docker-compose exec web php migrations.php diff
```

### Tecnologias Utilizadas
- **Backend**: PHP 8.2, Doctrine ORM
- **Frontend**: HTML5, CSS3, JavaScript
- **Banco**: PostgreSQL
- **Container**: Docker
- **Dependências**: Composer

### Problemas Comuns

1. **Erro de conexão com o banco**:
   - Verifique as credenciais no arquivo `.env` (Se o arquivo não existe, você deve copiar o arquivo .env.example e remover o '.example' do nome do arquivo)
   - Confirme se o PostgreSQL está rodando

2. **Migrações não executam**:
   - Execute `php migrations.php status` para verificar
   - Use `php migrations.php migrate` para aplicar

3. **Docker não inicia**:
   - Verifique se o Docker está instalado
   - Execute `docker-compose up -d` novamente

# OBS: Para acessar a aplicação, é só abrir http://localhost: + a porta criada no docker-compose, que por padrão, é a porta 8000. 

---
