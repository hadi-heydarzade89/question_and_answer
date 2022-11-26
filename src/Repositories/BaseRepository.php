<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultRolesEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{

    public function __construct(protected Model $model)
    {
    }

    /**
     * @inheritDoc
     */
    public function index(): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(config('app.per_page'));
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model
    {
        $user = $this->model->create($data);
        $user->assignRole(DefaultRolesEnum::USER->value);
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, string $column, string $columnValue): ?bool
    {
        return $this->model->where($column, $columnValue)->update($data);
    }
}
