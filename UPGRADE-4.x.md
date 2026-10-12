UPGRADE 4.x
===========

UPGRADE FROM 4.0 to 4.1
=======================

## Requirements

PHP 7.2 or newer and Symfony 4.3 or newer are needed. An application on an older PHP or Symfony version
keeps installing 4.0.4, which Composer selects for it.

## SonataCoreBundle and SonataEasyExtendsBundle

`sonata-project/core-bundle` and `sonata-project/easy-extends-bundle` are no longer required by this bundle.
If your kernel registers `SonataCoreBundle` or `SonataEasyExtendsBundle`, require the package in your own
`composer.json`, otherwise Composer may remove it on the next update.

When `sonata-project/core-bundle` is installed, it must be 3.20. Its `Sonata\CoreBundle\Model\*`,
`Sonata\CoreBundle\Form\Type\Base*` and `Sonata\CoreBundle\Serializer\BaseSerializerHandler` names are aliases
of the classes this bundle extends now, so code that type hints them keeps working.

## Form types

The form types this bundle uses (`Sonata\Form\Type\DatePickerType` among them) are registered by
`SonataCoreBundle` 3.20 or by `SonataFormBundle`. Register one of the two.

The date of birth field of the user admin is a `Sonata\Form\Type\DatePickerType` now. A form type extension
declared for `Sonata\CoreBundle\Form\Type\DatePickerType` no longer applies to it.

## Mapping of the user groups

The relation between users and groups is applied by `SonataDoctrineBundle`, or by `SonataEasyExtendsBundle`
when your kernel registers that one and not `SonataDoctrineBundle`. Register one of the two, as before.
