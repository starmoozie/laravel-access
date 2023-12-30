<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Operations;

trait IndexOperation
{
    public function index()
    {
        try {
            $entries = $this->model->with($this->relations)->select($this->model->getFillable())->get();

            return $this->successMessage(
                new $this->collection($entries),
                $this->translationMessage(__FUNCTION__)
            );
        } catch (\Throwable $th) {
            report($th);

            return $this->failedMessage($th->getMessage());
        }
    }
}
