@extends('backend.partials.master')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Vertical tabs full height and divider */
        .vertical-tabs-container {
            display: flex;
            min-height: 600px;
        }
        .vertical-tabs-nav {
            min-width: 220px;
            max-width: 220px;
            border-right: 2px solid #e4e6ef;
            padding-right: 0;
        }
        .vertical-tabs-nav .nav-link {
            width: 100%;
            text-align: left;
            margin-bottom: 4px;
            padding: 12px 20px;
            border-radius: 6px 0 0 6px;
            color: #5e6278;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .vertical-tabs-nav .nav-link:hover {
            background-color: #f5f8fa;
            color: #009ef7;
        }
        .vertical-tabs-nav .nav-link.active {
            background-color: #f1faff;
            color: #009ef7;
            border-left-color: #009ef7;
        }
        .vertical-tabs-nav .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .vertical-tabs-content {
            flex: 1;
            padding-left: 30px;
        }
        .field-type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .field-type-string { background: #e8f4fd; color: #3699ff; }
        .field-type-integer { background: #fff4de; color: #ffa800; }
        .field-type-boolean { background: #c9f7f5; color: #1bc5bd; }
        .field-type-date { background: #ffe2e5; color: #f64e60; }
        .field-type-select { background: #eee5ff; color: #8950fc; }
        .field-type-tags { background: #d5f5ec; color: #50cd89; }
        .field-type-checkbox_group { background: #fff5f8; color: #e4a951; }
        .field-type-radio { background: #f1faff; color: #009ef7; }
        .add-field-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }
        .add-field-card h5 {
            color: white;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .add-field-card .form-label {
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .add-field-card .form-control,
        .add-field-card .form-select {
            background: rgba(255,255,255,0.95);
            border: none;
            padding: 10px 15px;
        }
        .add-field-card .btn-light {
            background: white;
            color: #667eea;
            font-weight: 600;
            padding: 10px 30px;
        }
        .add-field-card .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .custom-fields-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .custom-fields-table thead {
            background: #f5f8fa;
        }
        .custom-fields-table th {
            font-weight: 600;
            color: #3f4254;
            font-size: 12px;
            text-transform: uppercase;
            padding: 15px;
            border: none;
        }
        .custom-fields-table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eff2f5;
        }
        .custom-fields-table tbody tr:hover {
            background-color: #f9fafb;
        }
        .form-check-custom {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-check-custom input[type="checkbox"] {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Manage Custom Fields</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Custom Fields</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="vertical-tabs-container">
                            <!-- Tabs -->
                            <ul class="nav flex-column vertical-tabs-nav" id="modelTabs" role="tablist">
                                @php
                                    $icons = [
                                        'Tour' => 'fa-map-marker-alt',
                                        'Stay' => 'fa-bed',
                                        'Experience' => 'fa-compass',
                                        'Product' => 'fa-shopping-cart',
                                        'Blog' => 'fa-blog',
                                        'MenuItem' => 'fa-utensils',
                                        'default' => 'fa-cube'
                                    ];
                                @endphp
                                @foreach($models as $model => $label)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif"
                                                id="tab-{{ $loop->index }}"
                                                data-bs-toggle="pill"
                                                data-bs-target="#content-{{ $loop->index }}"
                                                type="button" role="tab"
                                                aria-controls="content-{{ $loop->index }}"
                                                aria-selected="@if($loop->first) true @else false @endif">
                                            <i class="fa {{ $icons[$label] ?? $icons['default'] }}"></i>{{ $label }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content vertical-tabs-content" id="modelTabsContent">
                                @foreach($models as $model => $label)
                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="content-{{ $loop->index }}" role="tabpanel"
                                         aria-labelledby="tab-{{ $loop->index }}">

                                        <!-- Add New Field Form -->
                                        <div class="add-field-card">
                                            <h5><i class="fa fa-plus-circle me-2"></i>Add New Custom Field for {{ $label }}</h5>
                                            <form method="POST" action="{{ route('admin.custom-fields.store') }}">
                                                @csrf
                                                <input type="hidden" name="model_type" value="{{ $model }}">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Field Name</label>
                                                        <input type="text" name="title" class="form-control" placeholder="e.g. Room Size" required>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Field Type</label>
                                                        <select name="type" class="form-select field-type">
                                                            <option value="string">Text</option>
                                                            <option value="integer">Number</option>
                                                            <option value="boolean">Checkbox (single)</option>
                                                            <option value="date">Date</option>
                                                            <option value="select">Select Dropdown</option>
                                                            <option value="tags">Tags (Multiple)</option>
                                                            <option value="checkbox_group">Checkbox Group</option>
                                                            <option value="radio">Radio Buttons</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label class="form-label">Required?</label>
                                                        <div class="form-check-custom">
                                                            <input type="checkbox" name="required" class="form-check-input" id="required-{{ $loop->index }}">
                                                            <label class="form-label mb-0" for="required-{{ $loop->index }}">Yes</label>
                                                        </div>
                                                    </div>

                                                    {{-- Only show for select, checkbox_group, radio --}}
                                                    <div class="col-md-12 d-none choices-wrapper">
                                                        <label class="form-label">Options (for dropdowns, checkboxes, radio)</label>
                                                        <select name="answers[]" class="form-control select2" multiple="multiple"></select>
                                                        <small class="text-white-50 mt-1 d-block">Type option and press Enter to add</small>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-light w-100 mt-4">
                                                            <i class="fa fa-plus me-2"></i>Add Field
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Existing Fields -->
                                        <div class="mt-4">
                                            <h5 class="mb-4"><i class="fa fa-list text-primary me-2"></i>Existing Custom Fields</h5>
                                            <table class="table custom-fields-table">
                                                <thead>
                                                <tr>
                                                    <th style="width: 35%">Field Name</th>
                                                    <th style="width: 20%">Field Type</th>
                                                    <th style="width: 25%">Validation Rules</th>
                                                    <th style="width: 20%">Options</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($fieldsByModel[$model] as $field)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $field->title }}</strong>
                                                        </td>
                                                        <td>
                                                            <span class="field-type-badge field-type-{{ $field->type }}">
                                                                {{ ucfirst(str_replace('_', ' ', $field->type)) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($field->rules)
                                                                <span class="badge badge-light-info">{{ $field->rules }}</span>
                                                            @else
                                                                <span class="text-muted">None</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(in_array($field->type, ['select', 'checkbox_group', 'radio', 'tags']) && $field->answer)
                                                                @php
                                                                    $answers = json_decode($field->answer, true) ?? [];
                                                                @endphp
                                                                @if(is_array($answers) && count($answers) > 0)
                                                                    <div style="max-width: 200px;">
                                                                        @foreach(array_slice($answers, 0, 3) as $answer)
                                                                            <span class="badge badge-light-primary me-1 mb-1" style="font-size: 10px;">{{ $answer }}</span>
                                                                        @endforeach
                                                                        @if(count($answers) > 3)
                                                                            <span class="badge badge-light-secondary" style="font-size: 10px;">+{{ count($answers) - 3 }} more</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">No options</span>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-5">
                                                            <div class="text-muted text-center">
                                                                <i class="fa fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                                                <p class="mb-0">No custom fields created yet for this module.</p>
                                                                <small>Use the form above to add your first custom field.</small>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

    <script>
        document.querySelectorAll('.field-type').forEach(function(select) {
            select.addEventListener('change', function() {
                let wrapper = this.closest('.row').querySelector('.choices-wrapper');
                if (['select', 'checkbox_group', 'radio'].includes(this.value)) {
                    wrapper.classList.remove('d-none');
                } else {
                    wrapper.classList.add('d-none');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({ tags: true,
                placeholder: "Add Options",});
        });
    </script>
@endpush
