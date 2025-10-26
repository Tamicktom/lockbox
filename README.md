# Lockbox - PHP Vanilla Starter

Estrutura mínima e moderna para projetos PHP vanilla: Router simples, Controllers, Views, Config, Helpers e qualidade (PHPUnit, PHPStan, PHPCS).

## Requisitos
- PHP 8.1+
- Composer
- Docker (opcional)

## Instalação
```bash
composer install
cp env.example .env
```

## Rodando localmente
- Servidor embutido do PHP:
```bash
composer start
```
Acesse `http://localhost:8000`.

- Com Docker (nginx + php-fpm):
```bash
docker compose up -d --build
```
Acesse `http://localhost:8080`.

## Testes e Qualidade
```bash
composer test     # PHPUnit
composer stan     # PHPStan
composer cs:check # PHPCS
composer cs:fix   # PHPCBF
```

## Estrutura de Pastas
```
public/           # index.php (Front Controller)
routes/           # web.php (Rotas)
src/
  Core/           # Router, Request, Response, View, Config
  Http/Controllers# Controllers
  Bootstrap.php   # Boot do app (dotenv, erros, config)
  helpers.php     # Helpers globais
views/            # Arquivos de view (.php)
config/           # Configurações
tests/            # Testes
```

## Licença
MIT

