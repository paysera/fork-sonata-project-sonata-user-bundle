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

namespace Sonata\UserBundle\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\Loader\XliffFileLoader;

class XliffTest extends TestCase
{
    /**
     * @dataProvider getXliffFiles
     */
    public function testXliffFileLoads(string $file, string $locale): void
    {
        $catalogue = (new XliffFileLoader())->load($file, $locale);

        $this->assertNotEmpty($catalogue->all());
    }

    public function getXliffFiles(): array
    {
        $files = [];
        foreach (glob(__DIR__.'/../../src/Resources/translations'.'/*.xliff') as $file) {
            $files[basename($file)] = [$file, explode('.', basename($file))[1]];
        }

        return $files;
    }
}
