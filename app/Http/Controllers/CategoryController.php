<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\DestoryCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
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
        return CategoryResource::collection($this->categoryService->getAllCategories());
    }

    /**
     * @param  StoreCategoryRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $dto = new CategoryStoreDTO(...$request->validated());
        $service = $this->categoryService->store($dto);
        $resource = CategoryResource::make($service);

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
        $resource = CategoryResource::make($service);

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
        $resource = CategoryResource::make($service);

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
