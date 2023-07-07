<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * @param  StoreBookRequest  $request
     * @return BookResource
     */
    public function store(StoreBookRequest $request): BookResource
    {
        return new BookResource(Book::create($request->validated()));
    }

    /**
     * @param  Book  $book
     * @return BookResource
     */
    public function show(Book $book): BookResource
    {
        return new BookResource($book);
    }

    /**
     * @param  UpdateBookRequest  $request
     * @param  Book  $book
     * @return BookResource
     */
    public function update(UpdateBookRequest $request, Book $book): BookResource
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    /**
     * @param  Book  $book
     * @return JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(['status' => 'success']);
    }
}
