<?php

namespace Richardds\ServerAdmin\Http;

use Illuminate\Http\Request;

trait CrudAssistance
{
    /**
     * Strip required parameter from array of attribute rules.
     *
     * @param array $rules
     * @return array
     */
    protected function stripRequired(array $rules)
    {
        $strippedRules = [];

        foreach ($rules as $attributeName => $rule) {
            $requirements = explode('|', $rule);

            if (in_array('required', $requirements)) {
                $index = array_search('required', $requirements);
                unset($requirements[$index]);
            }

            $strippedRules[$attributeName] = implode('|', $requirements);
        }

        return $strippedRules;
    }

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
