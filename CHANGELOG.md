CHANGELOG
=========

Next release
------------
## Breaking changes
- Validation errors are moved from error.validation to error.extensions.validation as per GraphQL spec recommendation [\#294](https://github.com/rebing/graphql-laravel/pull/294)
- SelectFields on interface types now only selects specific fields instead of all [\#294](https://github.com/rebing/graphql-laravel/pull/294)
  - Although this could be consider a bug fix, it changes what columns are selected and if your code as a side-effect dependent on all columns being selected, it will break

### Added
- New config options `headers` to send custom HTTP headers and `json_encoding_options` for encoding the JSON response [\#293](https://github.com/rebing/graphql-laravel/pull/293)
- Auto-resolve aliased fields [\#283](https://github.com/rebing/graphql-laravel/pull/283)
- Added declare(strict_types=1) directive to all files
- This project has a changelog `\o/`
- Internal
  - Test suite has been refactored and now features Database (SQLite) tests too

### Changed
- `ValidatorError`: remove setter and make it a constructor arg, add getter and rely on contracts
- Replace global helper `is_lumen` with static class call `\Rebing\GraphQL\Helpers::isLumen`

### Fixed
- SelectFields now works with wrapped types (nonNull, listOf)

2019-03-07, v1.21.2
-------------------

- Allow configuring a custom default field resolver [\#266](https://github.com/rebing/graphql-laravel/pull/266)
- Routes have now given names so they can be referenced [\#264](https://github.com/rebing/graphql-laravel/pull/264)
- Expose more fields on the default pagination type [\#262](https://github.com/rebing/graphql-laravel/pull/262)
- Mongodb support [\#257](https://github.com/rebing/graphql-laravel/pull/257)
- Add support for MorphOne relationships [\#238](https://github.com/rebing/graphql-laravel/pull/238)
- Checks for lumen when determining schema [\#247](https://github.com/rebing/graphql-laravel/pull/247)
- Internal changes:
  - Replace deprecated global `array_*` and `str_*` helpers with direct `Arr::*` and `Str::*` calls
  - Code style now enforced via [StyleCI](https://styleci.io/)

2019-03-07, v1.20.2
-------------------

- Fixed infinite recursion for InputTypeObject self reference [\#230](https://github.com/rebing/graphql-laravel/pull/230)

2019-03-03, v1.20.1
-------------------

- Laravel 5.8 support

2019-02-04, v1.19.1
-------------------

- Don't report certain GraphQL Errors

2019-02-03, v1.18.1
-------------------

- Mutation routes fix

2019-01-29, v1.18.0
-------------------

- Fix to allow recursive input objects [\#158](https://github.com/rebing/graphql-laravel/issues/158)

2019-01-24, v1.17.6
-------------------

- Fixed default error handler

2018-12-17, v1.17.3
-------------------

- Bump webonxy/graphql-php version requirement
- Add support for custom error handler config `handle_errors`

2018-12-17, v1.16.0
-------------------

- Fixed validation

2018-07-20, v1.14.2
-------------------

- Validation error messages
  Can now add custom validation error messages to Queries and Mutations

2018-05-16, v1.13.0
-------------------

- Added support for query complexity and depth ([more details](https://github.com/webonyx/graphql-php#security))
- Also added support for InputObjectType rules validation.

2018-04-20, v1.12.0
-------------------

- [Added support for Unions](https://github.com/rebing/graphql-laravel/blob/master/docs/advanced.md#unions) and [Interfaces](https://github.com/rebing/graphql-laravel/blob/master/docs/advanced.md#interfaces)

2018-04-10, v1.11.0
-------------------

- Rules supported for all Fields
  Added `rules` support for Query fields

2018-02-28, v1.9.5
------------------

- Allow subscription types to be added
  Supports creating the schema, but the underlying PHP functionality does not do anything.

2018-01-05, v1.8.2
------------------

- Updating route and controller to give us the ability to create multilevel URI names [\#69](https://github.com/rebing/graphql-laravel/pull/69)
- Updating route and controller so it give us the ability to create multi level URI names

2017-10-31, v1.7.3
------------------

- Composer fix

2017-10-04, v1.7.1
------------------

- SelectFields fix

2017-09-23, v1.6.1
------------------

- GET routes

2017-08-27, v1.5.0
------------------

- Enum types

2017-08-20, v1.4.9
------------------

- Privacy validation optimizied

2017-03-27, v1.4
------------------

- Initial release
