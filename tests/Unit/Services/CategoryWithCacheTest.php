<?php

namespace Tests\Unit\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Services\CategoryWithCacheService;
use App\Services\Users\CacheService;
use PHPUnit\Framework\TestCase;

class CategoryWithCacheTest extends TestCase
{
    protected CacheService $cacheService;
    protected CategoryRepository $categoryRepository;
    protected CategoryWithCacheService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->cacheService = $this->createMock(CacheService::class);

        $this->categoryService = new CategoryWithCacheService(
            $this->categoryRepository,
            $this->cacheService,
        );
    }

    public function testGetCategoryWithCache(): void
    {
        $cacheData = collect();

        $this->cacheService
            ->expects(self::once())
            ->method('get')
            ->willReturn($cacheData);

        $this->categoryRepository
            ->expects(self::never())
            ->method('index');

        $this->cacheService
            ->expects(self::never())
            ->method('set');

        $result = $this->categoryService->getCategories();

        $this->assertSame($cacheData, $result);
    }

    public function testGetCategoryWithoutCache(): void
    {
        $cacheData = null;

        $this->cacheService
            ->expects(self::once())
            ->method('get')
            ->willReturn($cacheData);

        $dbData = collect();

        $this->categoryRepository
            ->expects(self::once())
            ->method('index')
            ->willReturn($dbData);

        $this->cacheService
            ->expects(self::once())
            ->method('set')
            ->with('categories', $dbData, CategoryWithCacheService::SECONDS);

        $result = $this->categoryService->getCategories();

        $this->assertSame($dbData, $result);
    }
}
