<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param array $data
     * @param string $column
     * @param string $columnValue
     * @return bool|null
     */
    public function update(array $data, string $column, string $columnValue): ?bool;
}
