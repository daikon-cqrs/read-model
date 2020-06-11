<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Tests\ReadModel\Repository;

use Daikon\ReadModel\Repository\RepositoryInterface;
use Daikon\ReadModel\Repository\RepositoryMap;
use PHPUnit\Framework\TestCase;

final class RepositoryMapTest extends TestCase
{
    public function testConstructWithSelf(): void
    {
        $repositoryMock = $this->createMock(RepositoryInterface::class);
        $repositoryMap = new RepositoryMap(['mock' => $repositoryMock]);
        $newMap = new RepositoryMap($repositoryMap);
        $this->assertCount(1, $newMap);
        $this->assertNotSame($repositoryMap, $newMap);
        $this->assertEquals($repositoryMap, $newMap);
    }

    public function testPush(): void
    {
        $emptyMap = new RepositoryMap;
        $repositoryMock = $this->createMock(RepositoryInterface::class);
        $repositoryMap = $emptyMap->with('mock', $repositoryMock);
        $this->assertCount(1, $repositoryMap);
        $this->assertEquals($repositoryMock, $repositoryMap->get('mock'));
        $this->assertTrue($emptyMap->isEmpty());
    }
}
