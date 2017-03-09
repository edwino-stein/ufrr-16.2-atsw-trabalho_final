### Trabalho de Arquitetura e Tecnologias de Sistemas Web 2016.2

- Instituição: Universidade Federal de Roraima
- Professor: Leandro Nelinho Balico
- Aluno: Edwino Alberto Lopes Stein
- Matrícula: 1201324411

## Pré-requisitos:
 - PHP 5.5+ com os plugins:
    - intl;
    - mbstring;
    - json;
    - curl;
 - composer;

## Instalação

 - Instale o plugin de assets para o composer:
    $ composer global require "fxp/composer-asset-plugin:^1.2.0"

 - Instale as dependencias:
    $ composer install

 - De permissão aos diretórios:
    $ chmod 0777 runtime/  web/assets

 - Defina o documentRoot do servidor HTTP para o diretório web/
