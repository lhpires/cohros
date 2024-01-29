# RASCUNHO GERAL

# Sistema COHROS CONTATOS

URL BACKEND: http://localhost

URL FRONT: http://localhost:5174

Configurando BackEnd 

> Laravel Sail, executar o seguinte comando para baixar os pacotes:
> 

```php
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### Subindo Containers

```php
sail up -d (Alias configurado)
OU
./vendor/bin/sail up -d
```

### Configurando Front

Vamos aplicar o preview de acordo com a pasta dist (Para simular produção)

> Buildando a aplicação e gerando o preview posteriormente
> 

```powershell
npm run build ; npm run preview
```

### Populando usuários padrão

> Rodando a seeder vamos criar por padrão dois usuários para o sistema
> 

> Caso queira popular de forma massiva contatos e números, acessar o arquivo ./backend/database/seeders/DatabaseSeeder.php e descomentar o trecho necessário
> 

```powershell
sail artisan migrate:refresh --seed
```

<aside>
⚠️ Abaixo segue os acessos do sistema

</aside>

Usuário 1

email: [lucas@pires.dev.br](mailto:lucas@pires.dev.br)

senha: lucas

Usuário 2

email: [caique@pires.dev.br](mailto:caique@pires.dev.br)

senha: caique

<aside>
📢 Observações
</aside>

- A criação de contatos é composta por uma classe e regras especiais
- as models fora desenhadas e arquitetadas com relacionamentos entre elas
- adotei o processo de carregamento ***eager loading*** para o carregamento dos relacionamentos
- tomei a liberdade e peguei uma imagem do site da Cohros, para “embelezar” a tela de login
- modelo de número de contato está com Accessors e Mutators para manipulação e leitura dos dados

# Demonstração Sistema

[cohros.gif](frontend/public/cohros.gif)