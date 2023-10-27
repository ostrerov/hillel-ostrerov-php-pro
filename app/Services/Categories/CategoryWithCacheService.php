<?php

namespace App\Services\Categories;

use App\Repositories\Categories\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryWithCacheService
{
    public const SECONDS = 20;

    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected AllCategoriesStorage $allCategoriesStorage,
    ) {
    }

    public function getCategories(): Collection
    {
        $cachedData = $this->allCategoriesStorage->get();

        if ($cachedData === null) {
            $query = $this->categoryRepository->index();
            $this->allCategoriesStorage->set($query);
            return $query;
        }

        return $cachedData;
    }
}
