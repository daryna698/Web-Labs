<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
    }

    /**
     * Список категорій з пагінацією
     */
    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(10);

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
        $result = BlogCategory::destroy($id);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Категорію успішно видалено']);
        } else {
            return response()->json(['message' => 'Помилка видалення. Запис не знайдено'], 404);
        }
    }
}
