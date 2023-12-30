<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Operations;

trait DeleteOperation
{
    public function delete()
    {
        try {
            $this->model
                ->whereIn('id', request()->id)
                ->delete();

            return $this->successMessage(
                null,
                $this->translationMessage(__FUNCTION__)
            );
        } catch (\Throwable $th) {
            report($th);

            return $this->failedMessage($th->getMessage());
        }
    }
}
