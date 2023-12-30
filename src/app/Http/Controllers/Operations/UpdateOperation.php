<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Operations;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Starmoozie\LaravelAccess\app\Enums\HttpCode;

trait UpdateOperation
{
    public function update()
    {
        $request = app($this->request);

        try {
            $entry = $this->model->findOrFail($request->id);
            $entry->load($this->relations);

            $entry->update($request->validated());

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
