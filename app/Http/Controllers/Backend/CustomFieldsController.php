<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldsController extends Controller
{
    protected $models = [
        'App\Models\Products' => 'Products',
    ];

    public function index()
    {
        $fieldsByModel = [];
        foreach ($this->models as $model => $label) {
            $fieldsByModel[$model] = CustomField::where('model_type', $model)->get();
        }

        return view('backend.custom-fields.index', [
            'models' => $this->models,
            'fieldsByModel' => $fieldsByModel,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'       => 'required|string',
            'required'      => 'nullable|string',
            'answers'      => 'nullable',
            'model_type' => 'required|string',
        ]);
        $validated['required'] = @$validated['required'] == 'on' ? true : false;
        // Create the field definition for the model type
        CustomField::create($validated);

        return back()->with('success', 'Custom field created successfully!');
    }
}

