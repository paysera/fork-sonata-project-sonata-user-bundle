<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\UserBundle\Tests;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\SonataCoreBundle;
use Sonata\UserBundle\Entity\GroupManager;
use Sonata\UserBundle\Entity\UserManager;
use Sonata\UserBundle\Entity\UserManagerProxy;
use Sonata\UserBundle\Form\Type\ApiGroupType;
use Sonata\UserBundle\Form\Type\ApiUserType;
use Sonata\UserBundle\Form\Type\UserGenderListType;
use Sonata\UserBundle\Serializer\UserSerializerHandler;

class FormerCoreBundleParentsTest extends TestCase
{
    /**
     * @dataProvider getClassesWithFormerParents
     */
    public function testObjectIsAnInstanceOfTheFormerCoreBundleParent(string $class, string $formerParent): void
    {
        if (!class_exists(SonataCoreBundle::class)) {
            $this->markTestSkipped('sonata-project/core-bundle is not installed.');
        }

        $object = (new \ReflectionClass($class))->newInstanceWithoutConstructor();

        $this->assertTrue($object instanceof $formerParent);
    }

    public function getClassesWithFormerParents(): array
    {
        return [
            'user manager' => [UserManager::class, 'Sonata\CoreBundle\Model\ManagerInterface'],
            'user manager proxy' => [UserManagerProxy::class, 'Sonata\CoreBundle\Model\BaseEntityManager'],
            'group manager' => [GroupManager::class, 'Sonata\CoreBundle\Model\PageableManagerInterface'],
            'API user form type' => [ApiUserType::class, 'Sonata\CoreBundle\Form\Type\BaseDoctrineORMSerializationType'],
            'API group form type' => [ApiGroupType::class, 'Sonata\CoreBundle\Form\Type\BaseDoctrineORMSerializationType'],
            'gender list form type' => [UserGenderListType::class, 'Sonata\CoreBundle\Form\Type\BaseStatusType'],
            'serializer handler' => [UserSerializerHandler::class, 'Sonata\CoreBundle\Serializer\BaseSerializerHandler'],
        ];
    }
}
