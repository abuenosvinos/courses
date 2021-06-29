<?php

declare(strict_types=1);

namespace App\Course\Infrastructure\Redis;

use App\Course\Domain\Entity\CourseCategory;
use App\Course\Domain\Entity\CourseLevel;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class RedisCacheAdapter
{
    private TagAwareCacheInterface $doctrineResultCachePool;

    public function __construct(TagAwareCacheInterface $doctrineResultCachePool)
    {
        $this->doctrineResultCachePool = $doctrineResultCachePool;
    }

    public function cleanCourseCategory(CourseCategory $courseCategory, LifecycleEventArgs $args)
    {
        $this->doctrineResultCachePool->delete(urlencode('[CourseCategory||searchAll][1]'));
    }

    public function cleanCourseLevel(CourseLevel $courseLevel, LifecycleEventArgs $args)
    {
        $this->doctrineResultCachePool->delete(urlencode('[CourseLevel||searchAll][1]'));
    }
}
