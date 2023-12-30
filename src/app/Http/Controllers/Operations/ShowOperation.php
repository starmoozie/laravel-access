<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Operations;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Starmoozie\LaravelAccess\app\Enums\HttpCode;

trait ShowOperation
{
    public function show($id)
    {
        try {
            $entry = $this->model
                ->with($this->relations)
                ->select($this->model->getFillable())
                ->whereId($id)
                ->firstOrFail();

            return $this->successMessage(
                new $this->resource($entry),
                $this->translationMessage(__FUNCTION__)
            );
        } catch (ModelNotFoundException $th) {
            \report($th);

            return $this->failedMessage(__('laravel-access-trans::message.not_found'), HttpCode::NOT_FOUND);
        } catch (\Throwable $th) {
            report($th);

            return $this->failedMessage($th->getMessage());
        }
    }
}
