<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\DestoryCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\CategoryShowRequest;
use App\Http\Resources\Category\CategoryModelResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController
{
    /**
     * @param  CategoryService  $categoryService
     */
    public function __construct(
        protected CategoryService $categoryService,
    ) {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryWithoutBooksResource::collection(
            $this->categoryService->getAllCategories()
        );
    }

    /**
     * @param  StoreCategoryRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $dto = new CategoryStoreDTO(...$request->validated());
        $service = $this->categoryService->store($dto);
        $resource = CategoryWithoutBooksResource::make($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param  ShowCategoryRequest  $request
     * @return JsonResponse
     */
    public function show(ShowCategoryRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->show($validatedData['id']);
        $resource = CategoryWithoutBooksResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryShowRequest $request
     * @return JsonResponse
     */
    public function showIterator(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showIterator($validatedData['id']);

        $resource = CategoryResource::collection($service->getIterator()->getArrayCopy());

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param CategoryShowRequest $request
     * @return JsonResponse
     */
    public function showModel(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showModel($validatedData['id']);

        $resource = CategoryModelResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param  UpdateCategoryRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request): JsonResponse
    {
        $dto = new CategoryUpdateDTO(...$request->validated());
        $service = $this->categoryService->update($dto);
        $resource = CategoryWithoutBooksResource::make($service);

        return $resource->response()->setStatusCode(200);
    }


    /**
     * @param  DestoryCategoryRequest  $request
     * @return Response
     */
    public function destroy(DestoryCategoryRequest $request): Response
    {
        $validatedData = $request->validated();
        $this->categoryService->destroy($validatedData['id']);

        return response()->noContent();
    }
}
