<?php

namespace App\Helpers;

use Givebutter\LaravelCustomFields\Models\CustomField;
use Givebutter\LaravelCustomFields\Models\CustomFieldResponse;

class CustomFieldHelper
{
    /**
     * Store custom field responses for a given model instance
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $fieldsData   // $request->input('custom_fields')
     */
    public static function saveResponses($model, array $fieldsData)
    {

        foreach ($fieldsData as $fieldId => $value) {
            $field = CustomField::find($fieldId);

            if (!$field) continue;

            $responseData = [
                'field_id'   => $field->id,
                'model_id'   => $model->id,
                'model_type' => get_class($model),
                'value_str'  => null,
                'value_text' => null,
                'value_int'  => null,
                'value_json' => null,
            ];
            if (is_array($value)) {
                $value = json_encode($value); // store tags as JSON
            }
            // Decide which column to store the value based on field type
            switch ($field->type) {
                case 'string':
                    $responseData['value_str'] = $value;
                    break;

                case 'text':
                    $responseData['value_text'] = $value;
                    break;

                case 'integer':
                case 'number':
                    $responseData['value_int'] = (int) $value;
                    break;

                case 'boolean':
                case 'checkbox':
                    $responseData['value_int'] = $value ? 1 : 0;
                    break;

                case 'json':
                case 'select':
                case 'radio':
                    $responseData['value_json'] = is_array($value) ? json_encode($value) : $value;
                    break;

                case 'date':
                    $responseData['value_str'] = $value;
                    break;

                default:
                    $responseData['value_str'] = $value;
                    break;
            }


            $response = new \Givebutter\LaravelCustomFields\Models\CustomFieldResponse();
            $response->forceFill($responseData)->save();
        }
    }
    public static function updateResponses($model, array $fieldsData)
    {

        foreach ($fieldsData as $fieldId => $value) {
            $field = CustomField::find($fieldId);

            if (!$field) continue;
            if (is_array($value)) {
                $value = json_encode($value); // store tags as JSON
            }
            $responseData = [
                'field_id'   => $field->id,
                'model_id'   => $model->id,
                'model_type' => get_class($model),
                'value_str'  => $value,
                'value_text' => null,
                'value_int'  => null,
                'value_json' => null,
            ];

            // Decide which column to store the value based on field type
//            switch ($field->type) {
//                case 'string':
//                    $responseData['value_str'] = $value;
//                    break;
//
//                case 'text':
//                    $responseData['value_text'] = $value;
//                    break;
//
//                case 'integer':
//                case 'number':
//                    $responseData['value_int'] = (int) $value;
//                    break;
//
//                case 'boolean':
//                case 'checkbox':
//                    $responseData['value_int'] = $value ? 1 : 0;
//                    break;
//
//                case 'json':
//                case 'select':
//                case 'radio':
//                    $responseData['value_json'] = is_array($value) ? json_encode($value) : $value;
//                    break;
//
//                case 'date':
//                    $responseData['value_str'] = $value;
//                    break;
//
//                default:
//                    $responseData['value_str'] = $value;
//                    break;
//            }
            $response = CustomFieldResponse::where('model_id', $model->id)->where('field_id', $fieldId)->first();
            if ($response == null) {
                $response = new \Givebutter\LaravelCustomFields\Models\CustomFieldResponse();

            };
            $response->forceFill($responseData)->save();
        }
    }
}
