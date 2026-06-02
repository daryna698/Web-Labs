<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use Illuminate\Http\Request;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository // властивість через яку будемо звертатись в репозиторій категорій
)
    {
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return $paginator;
    }

    public function store(Request $request)
    {
        //
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) { //якщо ід не знайдено
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all(); //отримаємо масив даних, які надійшли з форми


        $result = $item->update($data); //оновлюємо дані об'єкта і зберігаємо в БД

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено'
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
