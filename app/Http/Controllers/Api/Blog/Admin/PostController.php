<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use Illuminate\Support\Str;
use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Http\Resources\Api\Blog\Admin\PostResource;
use App\Http\Controllers\Controller;

class PostController extends BaseController
{
    use DispatchesJobs;

    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
    }

    /**
     * Вивід списку з динамічним пошуком та пагінацією
     */
    public function index(Request $request)
    {
        // Зчитуємо параметри з фронтенду
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', null);
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'DESC');

        $paginator = $this->blogPostRepository->getAllWithPaginate($perPage, $search, $sortBy, $sortOrder);

        return PostResource::collection($paginator);
    }

    public function show(string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => "Статтю з ID={$id} не знайдено"], 404);
        }

        return response()->json($item);
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);
            return response()->json(['success' => 'Успішно збережено']);
        } else {
            return response()->json(['msg' => 'Помилка збереження'], 500);
        }
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено'
            ]);
        } else {
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);
            return response()->json(['success' => 'Статтю успешно видалено']);
        } else {
            return response()->json(['msg' => 'Помилка видалення. Запис не знайдено'], 404);
        }
    }
}
