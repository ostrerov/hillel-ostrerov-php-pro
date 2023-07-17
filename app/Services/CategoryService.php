<?php

namespace App\Services;

use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * @param  CategoryRepository  $categoryRepository
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->categoryRepository->index();
    }

    /**
     * @param  CategoryStoreDTO  $data
     * @return CategoryIterator
     */
    public function store(CategoryStoreDTO $data): CategoryIterator
    {
        $categoryId = $this->categoryRepository->store($data);
        return $this->categoryRepository->getById($categoryId);
    }

    /**
     * @param  int  $id
     * @return CategoryIterator
     */
    public function show(int $id): CategoryIterator
    {
        return $this->categoryRepository->getById($id);
    }

    /**
     * @param  CategoryUpdateDTO  $data
     * @return CategoryIterator
     */
    public function update(CategoryUpdateDTO $data): CategoryIterator
    {
        $this->categoryRepository->update($data);
        return $this->categoryRepository->getById($data->getId());
    }

    /**
     * @param  int  $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->categoryRepository->destroy($id);
    }

    /**
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAllCategories();
    }
}
