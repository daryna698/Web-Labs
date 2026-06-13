<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogPostRepository.
 */
class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }
    /**
     * Публічний список статей (тільки опубліковані) з пагінацією, пошуком і сортуванням
     */
    public function getAllPublishedWithPaginate($perPage = 10, $search = null, $sortBy = 'id', $sortOrder = 'DESC')
    {
        $columns = ['id', 'title', 'slug', 'excerpt', 'is_published', 'published_at', 'user_id', 'category_id'];

        $allowedSortColumns = ['id', 'title', 'published_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }
        $sortOrder = strtolower($sortOrder) === 'asc' ? 'ASC' : 'DESC';

        $query = $this->startConditions()
            ->select($columns)
            ->where('is_published', true)
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                'user:id,name',
            ]);

        if (!empty($search)) {
            $query->where('title', 'LIKE', $search . '%');
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Отримати один пост для публічного перегляду (з підвантаженими звʼязками)
     */
    public function getOne($id)
    {
        return $this->startConditions()
            ->with(['category:id,title', 'user:id,name'])
            ->find($id);
    }
    /**
     * Отримати список статей з динамічною пагінацією, пошуком та сортуванням
     */
    public function getAllWithPaginate($perPage = 10, $search = null, $sortBy = 'id', $sortOrder = 'DESC')
    {
        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id'];

        $allowedSortColumns = ['id', 'title', 'is_published', 'published_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }
        $sortOrder = strtolower($sortOrder) === 'asc' ? 'ASC' : 'DESC';

        $query = $this->startConditions()
            ->select($columns)
            ->with([
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                'user:id,name',
            ]);

        if (!empty($search)) {
            $query->where('title', 'LIKE', $search . '%');
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Отримати модель для редагування / перегляду
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()
            ->with(['category:id,title', 'user:id,name'])
            ->find($id);
    }
}
