<?php

namespace App\Http\Controllers;

use App\Exceptions\CategoryNameExistsException;
use App\Http\Requests\Category\DestoryCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryModelResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Http\Resources\ErrorResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Categories\CategoryService;
use App\Services\Categories\CategoryWithCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController
{
    /**
     * @param CategoryService $categoryService
     * @param CategoryWithCacheService $categoryWithCacheService
     */
    public function __construct(
        protected CategoryService $categoryService,
        protected CategoryWithCacheService $categoryWithCacheService,
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
     * @return JsonResponse
     */
    public function cachedIndex(): JsonResponse
    {
        $service = $this->categoryWithCacheService->getCategories();

        $resource = CategoryWithoutBooksResource::collection($service);
        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse|ErrorResource
     */
    public function store(StoreCategoryRequest $request): JsonResponse|ErrorResource
    {
        $dto = new CategoryStoreDTO(...$request->validated());
        try {
            $service = $this->categoryService->store($dto);
            $resource = CategoryWithoutBooksResource::make($service);
            return $resource->response()->setStatusCode(201);
        } catch (CategoryNameExistsException $e) {
            return new ErrorResource($e);
        }
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
     * @param ShowCategoryRequest $request
     * @return JsonResponse
     */
    public function showIterator(ShowCategoryRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showIterator($validatedData['id']);

        $resource = CategoryResource::collection($service->getIterator()->getArrayCopy());

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param ShowCategoryRequest $request
     * @return JsonResponse
     */
    public function showModel(ShowCategoryRequest $request): JsonResponse
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
