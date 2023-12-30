<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

use Starmoozie\LaravelAccess\app\Models\Menu as Model;
use Starmoozie\LaravelAccess\app\Http\Resources\Menu\{
    Resource,
    Collection
};
use Starmoozie\LaravelAccess\app\Http\Requests\MenuRequest as Request;

class MenuController extends BaseController
{
    protected $model      = Model::class;
    protected $request    = Request::class;
    protected $resource   = Resource::class;
    protected $collection = Collection::class;
    protected $relations  = ['permissions'];

    public function store()
    {
        $request = app($this->request);

        try {
            $entry = \DB::transaction(function () use ($request) {
                $entry = $this->model->create($request->validated());

                foreach ($this->relations as $relation) {
                    $entry->{$relation}()->sync(\array_column($request->{$relation}, 'id'));
                }

                $entry->load($this->relations);

                return $entry;
            });

            return $this->successMessage(
                new $this->resource($entry),
                $this->translationMessage(__FUNCTION__)
            );
        } catch (\Throwable $th) {
            report($th);

            return $this->failedMessage($th->getMessage());
        }
    }

    public function update()
    {
        $request = app($this->request);

        try {

            $entry = \DB::transaction(function () use ($request) {
                $entry = $this->model->findOrFail($request->id);

                $entry->update($request->validated());

                foreach ($this->relations as $relation) {
                    $entry->{$relation}()->sync(\array_column($request->{$relation}, 'id'));
                }

                $entry->load($this->relations);

                return $entry;
            });

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
