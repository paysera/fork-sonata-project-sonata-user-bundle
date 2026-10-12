# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [4.1.0](https://github.com/paysera/fork-sonata-project-sonata-user-bundle/compare/4.0.4...4.1.0) - 2026-10-12
### Added
- PHP 8 is allowed: `php ^7.3 || ^8.0`
- The user to group relation is registered through `sonata-project/doctrine-extensions` when `SonataDoctrineBundle` is registered; with `SonataEasyExtendsBundle` alone it is registered as before

### Changed
- Classes of `sonata-project/core-bundle` are replaced by their counterparts in `sonata-project/doctrine-extensions` and `sonata-project/form-extensions`
- `sonata-project/datagrid-bundle` 3 is allowed
- `sonata-project/doctrine-extensions` 1.9 or newer is required

### Removed
- Requirement of `sonata-project/core-bundle` and `sonata-project/easy-extends-bundle`
- PHP 7.0, 7.1 and 7.2

## [4.0.4](https://github.com/paysera/fork-sonata-project-sonata-user-bundle/compare/4.0.3...4.0.4) - 2022-01-19
### Added
- Symfony 4.x compatibility

### Changed
- Travis related configuration

## [4.0.3](https://github.com/paysera/fork-sonata-project-sonata-user-bundle/compare/4.0.2...4.0.3) - 2017-12-26
### Added
- PHP 7.0 compatibility

### Removed
- PHP 7.1 requirement

## [4.0.2](https://github.com/paysera/fork-sonata-project-sonata-user-bundle/compare/4.0.1...4.0.2) - 2017-12-26
### Changed
- Package name (fork support)

## [4.0.1](https://github.com/sonata-project/SonataUserBundle/compare/4.0.0...4.0.1) - 2017-12-20
### Fixed
- Fixed flipped choices values/labels in SecurityRolesType when using symfony 2.8
- Admin pool variable in admin resetting templates

## [4.0.0](https://github.com/sonata-project/SonataUserBundle/compare/3.6.0...4.0.0) - 2017-12-04
### Added
- Add support for FOSUser 2.0
- Added missing `swiftmailer` dependency

### Changed
- Risky code change for PHP 7
- Made `sonata-project/google-authenticator` an optional dependency
- Moved public methods of `User` to `UserInterface`
- Lowered upper composer dependencies
- default values moved to the Configuration class
- `sonata.user.admin.user` and `sonata.user.admin.group` are public now

### Fixed
- Fixed PHPDoc
- Fixed wrong parent calls in UserManager
- Fixed wrong router call in Controller
- missing logo in templates

### Removed
- Removed removed user model properties
- Removed deprecated code

## [3.6.0](https://github.com/sonata-project/SonataUserBundle/compare/3.5.0...3.6.0) - 2017-12-04
### Added
- make Roles in SecurityRolesType translateable
- Added Russian translations

### Changed
- Changed internal folder structure to `src`, `tests` and `docs`

### Fixed
- Added a check to the UserAclVoter class to ensure the subject is an object

## [3.5.0](https://github.com/sonata-project/SonataUserBundle/compare/3.4.0...3.5.0) - 2017-11-04
### Changed
- Rollback to PHP 5.6 as minimum support.

## [3.4.0](https://github.com/sonata-project/SonataUserBundle/compare/3.3.0...3.4.0) - 2017-10-22
### Fixed
- Fixed the twig configuration setting bug.

### Removed
- Support for old versions of php and Symfony.

## [3.3.0](https://github.com/sonata-project/SonataUserBundle/compare/3.2.4...3.3.0) - 2017-10-22
### Changed
- Use sonata admin pool the get the master role name

### Fixed
- `AccountBlockService` extends `AbstractAdminBlockService` instead of wrong `AbstractBlockService`
- missing spanish translations were added

## [3.2.4](https://github.com/sonata-project/SonataUserBundle/compare/3.2.3...3.2.4) - 2017-06-14
### Added
- Added Dutch translation for `title_user_authentication`

### Changed
- Google Authenticator 2 is now allowed

### Fixed
- Deprecated block service usage
- Compatibility with Twig 2.0 was improved
- Fixed hardcoded paths to classes in `.xml.skeleton` files of config

## [3.2.3](https://github.com/sonata-project/SonataUserBundle/compare/3.2.2...3.2.3) - 2017-03-16
### Fixed
- Fix non-use of container for has/get services.

## [3.2.2](https://github.com/sonata-project/SonataUserBundle/compare/3.2.1...3.2.2) - 2017-03-08
### Fixed
- Fixed empty route after registration
- Added missing throw in change password process
- Avoid deprecation message by using request_stack when it is present
- Avoid deprecation message by changing CSRF token generation when possible
- Wrong factory definition

### Removed
- Removed form types non FQCN on SF2.8+
- Removed deprecations about form factory on SF2.8

## [3.2.1](https://github.com/sonata-project/SonataUserBundle/compare/3.2.0...3.2.1) - 2017-02-09
### Added
- Add missing (optional) dependency for JMSSerializerBundle, needed for the services defined in serializer.xml and api_form.xml

### Fixed
- FOSRestBundle 2.x was improved
- fixed a cross dependency when using UserBundle with FOSRestBundle and NelmioApiDocBundle depending JMSSerializerBundle.
- add missing use for DependencyInjection\Reference
- Added $ sign that was missing from a previous refactoring
- `asset` return `/` if default avatar is empty
- Declaration of `UserManagerProxy` uses `Sonata\UserBundle\Entity\User` instead of `%fos_user.model.user.class%`
- the bundle can be used without a `sonata.user.editable_role_builder` service
- Issue where service was injected to constructor at wrong position
- Missing italian translations
- Deprecation of `security.context` on `AdminSecurityController`

## [3.2.0](https://github.com/sonata-project/SonataUserBundle/compare/3.1.0...3.2.0) - 2016-11-25
### Added
- Added russian and ukrainian translations

### Deprecated
- Relying on the `sonata_basket_delivery_redirect` is deprecated and won't be supported anymore

### Fixed
- The reset password url now points to the action dedicated to administrators again

### Removed
- The conflict rule for FOSRestBundle `>=2.0`

## [3.1.0](https://github.com/sonata-project/SonataUserBundle/compare/3.0.1...3.1.0) - 2016-10-14
### Changed
- The `friendsofsymfony/rest-bundle` dependency is optional again
- The `jms/serializer-bundle` dependency is optional again
- The `nelmio/api-doc-bundle` dependency is optional again
- Changed implementation of `SecurityFOSUser1Controller::loginAction`
- Changed implementation of `AdminSecurityController::loginAction`
- Changed how the error message is translated in `login.html.twig`
- Changed how the error message is translated in `base_login.html.twig`

### Fixed
- Fixed a potential null error in `SecurityFOSUser1Controller::loginAction`
- Fixed a potential empty route after calling `RegistrationFOSUser1Controller::registerAction`
- Fixed wrong route name "sonata_user_admin_resetting_request", replaced with "sonata_user_resetting_request"
- Symfony 3 security classes use in `AdminSecurityController`
- Fixed a possible security risk as noticed in this [line](https://github.com/sonata-project/SonataUserBundle/blob/88a962818dd6218379ff1439183a15647837bda0/Controller/AdminSecurityController.php#L40)

### Removed
- Internal test classes are now excluded from the autoloader
- Removed translation for 'Bad credentials' message in `SonataUserBundle.de.xliff`

## [3.0.1](https://github.com/sonata-project/SonataUserBundle/compare/3.0.0...3.0.1) - 2016-05-20
### Changed
- Admin classes extend `Sonata\AdminBundle\Admin\AbstractAdmin`
