<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Resources\Api\Blog\PostResource;
use App\Repositories\BlogPostRepository;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository
    ) {
    }

    /**
     * Список постів з пагінацією та пошуком (для головної сторінки)
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', null);
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'DESC');

        $paginator = $this->blogPostRepository->getAllPublishedWithPaginate(
            $perPage,
            $search,
            $sortBy,
            $sortOrder
        );

        return PostResource::collection($paginator);
    }

    /**
     * Перегляд одного поста
     */
    public function show(string $id)
    {
        $item = $this->blogPostRepository->getOne($id);

        if (empty($item)) {
            return response()->json(['message' => "Статтю з ID={$id} не знайдено"], 404);
        }

        return new PostResource($item);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
