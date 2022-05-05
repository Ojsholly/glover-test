<?php

namespace App\Services\Update;

use App\Models\Update;
use App\Services\Service;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class UpdateService extends Service
{
    /**
     * @param array $params
     * @param array $query
     * @return Builder[]|Collection
     */
    public function findAll(array $params = [], array $query = []): Collection|array
    {
        $updates = Update::query();

        /**
         * Return a paginated and sorted list of results when specified from the request query parameters.
         */
        $updates->where($params)->when((array_key_exists('orderBy', $query) && array_key_exists('sort', $query)), function ($update) use ($query){
            return $update->orderBy($query['orderBy'], $query['sort']);
        })->when(array_key_exists('type', $query), function ($update) use ($query){
          return $update->where('type', $query['type']);
        })->when((array_key_exists('per_page', $query) && (array_key_exists('page', $query))), function ($update) use ($query){
            return $update->paginate($query['per_page'], ['*'], 'page', $query['page']);
        });

        return $updates->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return Update::create($data);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Throwable
     */
    public function find(string $id): mixed
    {
        $update = Update::findByUuid($id);
        throw_if(!$update, new ModelNotFoundException("Requested update not found."));
        throw_if($update->confirmed(), new AuthorizationException("Update previously approved already."));
        return $update;
    }

    /**
     * @param array $data
     * @param string $id
     * @return mixed
     * @throws Throwable
     */
    public function update(array $data, string $id): mixed
    {
        $update = $this->find($id);
        $update->update($data);

        return $update;
    }
}
