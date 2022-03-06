<?php

namespace App\Repositories;

abstract class BaseRepository
{
    public function getOne($where_data, $where_in_data = [], $used_lock = false)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data, $used_lock) {
            foreach ($where_in_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
            if ($used_lock) {
                $query->lockForUpdate();
            }
        })->first();
    }

    public function getAll($where_data, $where_in_data = [], $used_lock = false)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data, $used_lock) {
            foreach ($where_in_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
            if ($used_lock) {
                $query->lockForUpdate();
            }
        })->get();
    }

    public function create($data)
    {
        return $this->query()->create($data);
    }

    public function update($where_data, $update_data)
    {
        $where_result = $this->query()->where(function ($query) use ($where_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
        })->get();
        $where_result = $where_result->toArray();
        foreach ($where_result as $value) {
            $model = $this->query()->find($value['id']);
            foreach ($update_data as $update_key => $update_value) {
                $model[$update_key] = $update_value;
            }
            $model->update();
        }
    }

    public function updateOrCreate($v_data, $update_data)
    {
        return $this->query()->updateOrCreate($v_data, $update_data);
    }

    public function query()
    {
        return call_user_func(static::MODEL.'::query');
    }
}
