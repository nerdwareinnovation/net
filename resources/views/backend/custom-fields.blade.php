
@if(isset($custom_fields))

@foreach($custom_fields as $field)
    @php
        if(isset($stay)){
           $responses = $custom_field_response->customFieldResponses();
}

    @endphp
    @if(isset($responses))

        @php

            $response = $responses->where('field_id',$field['id'])->first();
        @endphp

    @endif
    <div class="mb-3 col-md-6">
        <label class="form-label">{{ $field['title'] }}</label>

        @php
            $required = $field['required'] ? 'required' : '';
        @endphp

        @switch($field['type'])
            @case('string')
                <input type="text"
                       name="custom_fields[{{ $field['id'] }}]"
                       class="form-control"
                       value="{{@$response->value_str}}"
                    {{ $required }}>
                @break

            @case('number')
                <input type="number"
                       name="custom_fields[{{ $field['id'] }}]"
                       class="form-control"
                       value="{{@$response->value_str}}"
                    {{ $required }}>
                @break

            @case('checkbox')
                <div class="form-check">
                    <input type="checkbox"
                           name="custom_fields[{{ $field['id'] }}]"
                           class="form-check-input"
                           value="1"
                        {{ $required }}>
                    <label class="form-check-label">{{ $field['title'] }}</label>
                </div>
                @break

            @case('date')
                <input type="date"
                       name="custom_fields[{{ $field['id'] }}]"
                       class="form-control"
                       value="{{@$response->value_str}}"
                    {{ $required }}>
                @break

            @case('select')
                @php
                    $options = is_array($field['answers']) ? $field['answers'] : [];

                @endphp
                <select name="custom_fields[{{ $field['id'] }}]" class="form-select" {{ $required }}>
                    <option value="">-- Select --</option>
                    @foreach($options as $option)
                        <option value="{{ $option }}" {{@$response->value_str == $option ? 'selected': ''}}>{{ $option }}</option>
                    @endforeach
                </select>
                @break

            @case('checkbox_group')
            @case('radio')
                @php
                    $options = is_array($field['answers']) ? $field['answers'] : [];
                @endphp
                @foreach($options as $option)
                    <div class="form-check">
                        <input type="radio"
                               name="custom_fields[{{ $field['id'] }}]"
                               value="{{ $option }}"
                               {{@$response->value_str == $option ? 'checked': ''}}
                               class="form-check-input"
                            {{ $required }}>
                        <label class="form-check-label">{{ $option }}</label>
                    </div>
                @endforeach
                @break
            @case('tags')
                @php
                     $selected = json_decode(@$response->value_str, true) ?? [];


                @endphp
                <select name="custom_fields[{{ $field['id'] }}][]"
                        class="form-control select2"
                        multiple="multiple">
                    @foreach($selected as $option)
                        <option value="{{ $option }}"
                            selected>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
                @break

            @default
                <input type="text"
                       name="custom_fields[{{ $field['id'] }}]"
                       class="form-control"
                    {{ $required }}>
        @endswitch
    </div>
@endforeach
@endif

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({ tags: true,
                placeholder: "Add Options",});
        });
    </script>
@endpush
