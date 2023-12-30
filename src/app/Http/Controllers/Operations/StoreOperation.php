<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Operations;

trait StoreOperation
{
    public function store()
    {
        $request = app($this->request);

        try {
            $entry = $this->model->create($request->validated());
            $entry->load($this->relations);

            return $this->successMessage(
                new $this->resource($entry),
                $this->translationMessage(__FUNCTION__)
            );
        } catch (\Throwable $th) {
            report($th);

            return $this->failedMessage($th->getMessage());
        }
    }
}
