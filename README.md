# Lumen GraphQL

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/digiaonline/lumen-graphql/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/digiaonline/lumen-graphql/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/digiaonline/lumen-graphql/v/stable)](https://packagist.org/packages/digiaonline/lumen-graphql)
[![Total Downloads](https://poser.pugx.org/digiaonline/lumen-graphql/downloads)](https://packagist.org/packages/digiaonline/lumen-graphql)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/digiaonline/lumen-graphql/master/LICENSE)
[![Gitter](https://img.shields.io/gitter/room/norsoftware/open-source.svg?maxAge=2592000)](https://gitter.im/nordsoftware/open-source)

GraphQL module for the Laravel and Lumen PHP frameworks.

## Requirements

- PHP 5.6 or newer
- [Composer](http://getcomposer.org)
- [Lumen](https://lumen.laravel.com/) / [Laravel](https://laravel.com) 5.5 or newer

## Usage

### Installation

Run the following command to install the package through Composer:

```sh
composer require digiaonline/lumen-graphql
```

### Configure

Copy the configuration template in `config/graphql.php` to your application's `config` directory and modify according to your needs.
For more information see the [Configuration Files](http://lumen.laravel.com/docs/configuration#configuration-files) section in the Lumen documentation.

Available configuration options:

- **schema** `string` *Schema class name, must be an instance of `Youshido\GraphQL\Schema\Schema`*
- **type_resolver** `string` *Type resolver class name, must be an instance of `Digia\Lumen\GraphQL\Contracts\TypeResolverInterface`*
- **processor** `string` *Optional processor class name, must be an instance of `Youshido\GraphQL\Execution\Processor`*
- **enable_graphiql** `bool` *Whether or not the GraphiQL interface is enabled*
- **graphiql_token** `string` *Token required for accessing the GraphiQL interface*

### Bootstrapping

Add the following line to ```bootstrap/app.php```:

```php
$app->register(Digia\Lumen\GraphQL\GraphQLServiceProvider::class);
```

## Contributing

Please read the [guidelines](.github/CONTRIBUTING.md).

## License

See [LICENSE](LICENSE).
