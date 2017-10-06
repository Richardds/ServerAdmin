<?php

namespace Richardds\ServerAdmin\Http;

use Illuminate\Http\Request;

trait CrudAssistance
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Illuminate\Http\Request $request
     * @param array $attributes
     */
    protected function updateModel($model, Request $request, array $attributes)
    {
        foreach ($attributes as $attribute) {
            if ($request->has($attribute)) {
                $model->setAttribute($attribute, $request->get($attribute));
            }
        }
    }
}
