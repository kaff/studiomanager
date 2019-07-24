<?php

declare(strict_types=1);

namespace Tests\integration;

use App\Repository\ClassRepository;
use PHPUnit\Framework\TestCase;
use StudioManager\Domain\StudioClass;

class ClassRepositoryTest extends TestCase
{
    /**
     * @var string
     */
    static private $storagePath;

    /**
     * @var ClassRepository
     */
    private $repository;

    static public function setUpBeforeClass()
    {
        self::$storagePath = dirname(__DIR__, 2).'/var/storage';
    }

    public function setUp()
    {
        file_put_contents(self::$storagePath, "");

        $this->repository = new ClassRepository(self::$storagePath);
    }

    public function test_it_persist_studio_class()
    {
        $studioClass = $this->prepareStudioClass(new \DateTime('yesterday'), new \DateTime('tomorrow'));

        $result = $this->repository->save($studioClass);

        $this->assertEquals($studioClass, $result);
        $this->assertStorageEquals($studioClass);
    }

    function test_it_returns_studio_class_which_was_found_by_dates()
    {
        $someStudioClass = $this->prepareStudioClass(new \DateTime('tomorrow +1day'), new \DateTime('tomorrow +2days'));
        $some2StudioClass = $this->prepareStudioClass(new \DateTime('today'), new \DateTime('tomorrow'));
        $studioClassToFind = $this->prepareStudioClass(new \DateTime('yesterday -2days'), new \DateTime('yesterday'));

        $this->repository->save($someStudioClass);
        $this->repository->save($studioClassToFind);
        $this->repository->save($some2StudioClass);

        $result = $this->repository->findClassForDate(new \DateTime('yesterday -1day'));

        $this->assertEquals($studioClassToFind, $result);
    }

    function test_it_returns_null_when_there_is_not_any_class_for_given_dates()
    {
        $someStudioClass = $this->prepareStudioClass(new \DateTime('tomorrow +1day'), new \DateTime('tomorrow +2days'));
        $some2StudioClass = $this->prepareStudioClass(new \DateTime('today'), new \DateTime('tomorrow'));

        $this->repository->save($someStudioClass);
        $this->repository->save($some2StudioClass);

        $result = $this->repository->findClassForDate(new \DateTime('yesterday -1day'));

        $this->assertNull($result);
    }

    private function prepareStudioClass(\DateTime $startDate, \DateTime $endDate)
    {
        return new StudioClass(
            '__CLASS_NAME__',
            $startDate,
            $endDate,
            10
        );
    }

    private function assertStorageEquals(StudioClass $expected)
    {
        $storedContent = @file_get_contents(self::$storagePath);
        $this->assertEquals([
            (string) $expected->getUid() => $expected
        ], unserialize($storedContent));
    }
}
