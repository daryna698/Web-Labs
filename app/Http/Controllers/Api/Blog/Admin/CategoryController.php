<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
    }

    /**
     * Список категорій з пагінацією
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', null);

        $paginator = $this->blogCategoryRepository->getAllWithPaginate($perPage, $search);

        return CategoryResource::collection($paginator);
    }

    public function comboBox()
    {
        return response()->json(
            $this->blogCategoryRepository->getForComboBox()
        );
    }

    /**
     * Перегляд однієї категорії (для форми редагування)
     */
    public function show(string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => "Категорію id=[{$id}] не знайдено"], 404);
        }

        return new CategoryResource($item);
    }

    /**
     * Створення категорії
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogCategory())->create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item)
            ];
        } else {
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }

    /**
     * Оновлення категорії
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => new CategoryResource($item->fresh())
            ];
        } else {
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }

    /**
     * Видалення категорії
     */
    public function destroy(string $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => "Категорію id=[{$id}] не знайдено"], 404);
        }

        // Перевіряємо чи є пости з цією категорією
        $postsCount = \App\Models\BlogPost::where('category_id', $id)->count();

        if ($postsCount > 0) {
            return response()->json([
                'message' => "Неможливо видалити категорію — до неї прив'язано {$postsCount} публікацій. Спочатку змініть категорію у цих публікаціях."
            ], 422);
        }

        $result = \App\Models\BlogCategory::destroy($id);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Категорію успішно видалено']);
        } else {
            return response()->json(['message' => 'Помилка видалення'], 500);
        }
    }
}
