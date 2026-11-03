<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Book::query()->orderBy('id')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);

        $book = Book::create($validated);

        return response()->json($book, Response::HTTP_CREATED);
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json($book);
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'author' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        if ($validated === []) {
            return response()->json([
                'message' => 'At least one of title or author is required.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->update($validated);

        return response()->json($book->refresh());
    }

    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
