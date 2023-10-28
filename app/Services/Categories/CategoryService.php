<?php

namespace App\Services\Categories;

use App\Exceptions\CategoryNameExistsException;
use App\Models\Category;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\CategoryWithBooksIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
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
     * @param CategoryStoreDTO $data
     * @return CategoryWithoutBooksIterator
     * @throws CategoryNameExistsException
     */
    public function store(CategoryStoreDTO $data): CategoryWithoutBooksIterator
    {
        $isExistsByName = $this->categoryRepository->isExistsByName($data->getName());

        if ($isExistsByName === true) {
            return throw new CategoryNameExistsException('Category name exists already.', 400);
        }

        $categoryId = $this->categoryRepository->insertAndGetId($data);
        return $this->categoryRepository->getById($categoryId);
    }

    /**
     * @param  int  $id
     * @return CategoryWithoutBooksIterator
     */
    public function show(int $id): CategoryWithoutBooksIterator
    {
        return $this->categoryRepository->getById($id);
    }

    /**
     * @param int $id
     * @return CategoryWithBooksIterator
     */
    public function showIterator(int $id): CategoryWithBooksIterator
    {
        return $this->categoryRepository->getByIdIterator($id);
    }

    /**
     * @param int $id
     * @return Category
     */
    public function showModel(int $id): Category
    {
        return $this->categoryRepository->getByIdModel($id);
    }

    /**
     * @param  CategoryUpdateDTO  $data
     * @return CategoryWithoutBooksIterator
     */
    public function update(CategoryUpdateDTO $data): CategoryWithoutBooksIterator
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
