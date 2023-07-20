<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DestroyBookRequest;
use App\Http\Requests\Book\IndexBookRequest;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\ShowBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController
{
    /**
     * @param  BookService  $bookService
     */
    public function __construct(protected BookService $bookService)
    {
    }

    /**
     * @param  IndexBookRequest  $request
     * @return JsonResponse
     */
    public function index(IndexBookRequest $request): JsonResponse
    {
        $dto = new BookIndexDTO(...$request->validated());
        $service = $this->bookService->index($dto);
        $resource = BookResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param  StoreBookRequest  $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $dto = new BookStoreDTO(...$request->validated());
        $service = $this->bookService->store($dto);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * @param  ShowBookRequest  $request
     * @return JsonResponse
     */
    public function show(ShowBookRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $service = $this->bookService->show($validated['id']);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function showAll(): AnonymousResourceCollection
    {
        return BookResource::collection($this->bookService->getAllBooks());
    }

    /**
     * @param  UpdateBookRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request): JsonResponse
    {
        $dto = new BookUpdateDTO(...$request->validated());
        $service = $this->bookService->update($dto);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @param  DestroyBookRequest  $request
     * @return Response
     */
    public function destroy(DestroyBookRequest $request): Response
    {
        $validated = $request->validated();
        $this->bookService->destroy($validated['id']);

        return response()->noContent(200);
    }
}
