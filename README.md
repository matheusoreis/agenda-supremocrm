# Agenda de Contatos Supremo CRM

Sistema de agenda de contatos (CRUD de Contatos, Estados e Cidades) construído em **PHP puro**, sem frameworks.

## Stack

- **PHP 8.4**
- **PDO** para acesso a banco de dados
- **Composer** com autoload **PSR-4**
- **Router** próprio (sem framework) para despacho de rotas
- **Tailwind CSS** (via CDN)
- Consumo de **API externa (IBGE)** para importação de estados e cidades

## Funcionalidades

- CRUD completo de **Estados**, **Cidades** e **Contatos**.
- Busca com paginação em todas as listagens.
- Importação automática de Estados e Cidades via **API do IBGE**, com verificação de duplicidade.
- Validação de formulários em classes `Request` dedicadas.
- Layout com suporte a **dark mode** `localStorage`.

## Como rodar

```bash
composer install
composer run serve
```

O comando acima sobe um servidor local com `php -S localhost:8000 -t public`.

## Ponto de destaque

- Separação clara de responsabilidades sem depender de framework.
- Integração com API externa com tratamento de erros e prevenção de dados duplicados.
- Componentização de UI em PHP puro, reduzindo repetição entre as telas.

## Capturas de tela

![Contatos Dark Mode](https://i.imgur.com/rW3Zmkn.png)
![Contatos White Mode](https://i.imgur.com/kbcRbOP.png)

![Estados Dark Mode](https://i.imgur.com/6bZJfvO.png)
![Estados White Mode](https://i.imgur.com/deAqX6J.png)

![Cidades Dark Mode](https://i.imgur.com/bsfiTas.png)
![Cidades White Mode](https://i.imgur.com/qTifBGP.png)