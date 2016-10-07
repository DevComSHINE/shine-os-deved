<?php

class BaseModelObserver
{

    protected function clearCache($model)
    {

        $model_name = $model->table;

        Cache::tags($model_name)->flush();

    }

    public function saved($model)
    {
        $this->clearCache($model);
    }

    public function saving($model)
    {
        $this->clearCache($model);
    }

    public function updated($model)
    {
        $this->clearCache($model);
    }

    public function deleted($model)
    {
        $this->clearCache($model);
    }

    public function restored($model)
    {
        $this->clearCache($model);
    }

    public function created($model)
    {
        $this->clearCache($model);
    }
}
