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

namespace Sonata\UserBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\Doctrine\Mapper\DoctrineCollector;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector as EasyExtendsDoctrineCollector;
use Sonata\UserBundle\DependencyInjection\Configuration;
use Sonata\UserBundle\DependencyInjection\SonataUserExtension;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class SonataUserExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setParameter('kernel.bundles', ['SonataAdminBundle' => true]);

        DoctrineCollector::getInstance()->clear();
    }

    public function testGroupsRelationIsCollectedForSonataDoctrineByDefault(): void
    {
        $this->prependAndLoad();

        $this->assertArrayHasKey(BaseUser::class, DoctrineCollector::getInstance()->getAssociations());
    }

    public function testGroupsRelationIsCollectedForSonataDoctrineWhenBothMappingBundlesAreRegistered(): void
    {
        $this->setParameter('kernel.bundles', [
            'SonataAdminBundle' => true,
            'SonataDoctrineBundle' => true,
            'SonataEasyExtendsBundle' => true,
        ]);

        $this->prependAndLoad();

        $this->assertArrayHasKey(BaseUser::class, DoctrineCollector::getInstance()->getAssociations());
    }

    public function testGroupsRelationIsCollectedForEasyExtendsWhenOnlyThatBundleIsRegistered(): void
    {
        if (!class_exists(EasyExtendsDoctrineCollector::class)) {
            $this->markTestSkipped('sonata-project/easy-extends-bundle is not installed.');
        }

        EasyExtendsDoctrineCollector::getInstance()->clear();
        $this->setParameter('kernel.bundles', ['SonataAdminBundle' => true, 'SonataEasyExtendsBundle' => true]);

        $this->prependAndLoad();

        $this->assertArrayHasKey(BaseUser::class, EasyExtendsDoctrineCollector::getInstance()->getAssociations());
        $this->assertArrayNotHasKey(BaseUser::class, DoctrineCollector::getInstance()->getAssociations());
    }

    public function testLoadDefault(): void
    {
        $this->prependAndLoad();

        $this->assertContainerBuilderHasAlias(
            'sonata.user.user_manager',
            'sonata.user.orm.user_manager'
        );

        $this->assertContainerBuilderHasAlias(
            'sonata.user.group_manager',
            'sonata.user.orm.group_manager'
        );
    }

    public function testTwigConfigParameterIsSetting(): void
    {
        $fakeContainer = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['hasExtension', 'prependExtensionConfig'])
            ->getMock();

        $fakeContainer->expects($this->once())
            ->method('hasExtension')
            ->with($this->equalTo('twig'))
            ->willReturn(true);

        $fakeContainer->expects($this->once())
            ->method('prependExtensionConfig')
            ->with('twig', ['form_themes' => ['SonataUserBundle:Form:form_admin_fields.html.twig']]);

        foreach ($this->getContainerExtensions() as $extension) {
            if ($extension instanceof PrependExtensionInterface) {
                $extension->prepend($fakeContainer);
            }
        }
    }

    public function testTwigConfigParameterIsSet(): void
    {
        $fakeTwigExtension = $this->getMockBuilder(TwigExtension::class)
            ->setMethods(['load', 'getAlias'])
            ->getMock();

        $fakeTwigExtension->expects($this->any())
            ->method('getAlias')
            ->willReturn('twig');

        $this->container->registerExtension($fakeTwigExtension);

        $this->prependAndLoad();

        $twigConfigurations = $this->container->getExtensionConfig('twig');

        $this->assertArrayHasKey(0, $twigConfigurations);
        $this->assertArrayHasKey('form_themes', $twigConfigurations[0]);
        $this->assertEquals(
            ['SonataUserBundle:Form:form_admin_fields.html.twig'],
            $twigConfigurations[0]['form_themes']
        );
    }

    public function testTwigConfigParameterIsNotSet(): void
    {
        $this->prependAndLoad();

        $twigConfigurations = $this->container->getExtensionConfig('twig');

        $this->assertArrayNotHasKey(0, $twigConfigurations);
    }

    public function testCorrectModelClass(): void
    {
        $this->prependAndLoad(['class' => ['user' => 'Sonata\UserBundle\Tests\Entity\User']]);
    }

    public function testCorrectModelClassWithLeadingSlash(): void
    {
        $this->prependAndLoad(['class' => ['user' => '\Sonata\UserBundle\Tests\Entity\User']]);
    }

    public function testCorrectAdminClass(): void
    {
        $this->prependAndLoad(['admin' => ['user' => ['class' => '\Sonata\UserBundle\Tests\Admin\Entity\UserAdmin']]]);
    }

    public function testCorrectModelClassWithNotDefaultManagerType(): void
    {
        $this->prependAndLoad([
            'manager_type' => 'mongodb',
            'class' => [
                'user' => 'Sonata\UserBundle\Tests\Document\User',
                'group' => 'Sonata\UserBundle\Tests\Document\Group',
            ],
            'admin' => [
                'user' => ['class' => 'Sonata\UserBundle\Tests\Admin\Document\UserAdmin'],
                'group' => ['class' => 'Sonata\UserBundle\Tests\Admin\Document\GroupAdmin'],
            ],
        ]);
    }

    public function testIncorrectModelClass(): void
    {
        $this->expectException('InvalidArgumentException');

        $this->expectExceptionMessage('Model class "Foo\User" does not correspond to manager type "orm".');

        $this->prependAndLoad(['class' => ['user' => 'Foo\User']]);
    }

    public function testNotCorrespondingModelClass(): void
    {
        $this->expectException('InvalidArgumentException');

        $this->expectExceptionMessage(
            'Model class "Sonata\UserBundle\Admin\Entity\UserAdmin" does not correspond to manager type "mongodb".'
        );

        $this->prependAndLoad(['manager_type' => 'mongodb', 'class' => ['user' => 'Sonata\UserBundle\Admin\Entity\UserAdmin']]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMinimalConfiguration(): array
    {
        return (new Processor())->process((new Configuration())->getConfigTreeBuilder()->buildTree(), []);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions(): array
    {
        return [
            new SonataUserExtension(),
        ];
    }

    private function prependAndLoad(array $configurationValues = []): void
    {
        $configs = [$this->getMinimalConfiguration(), $configurationValues];

        foreach ($this->container->getExtensions() as $extension) {
            if ($extension instanceof PrependExtensionInterface) {
                $extension->prepend($this->container);
            }

            $extension->load($configs, $this->container);
        }
    }
}
