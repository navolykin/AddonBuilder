@extends('layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="border-primary card">
                    <h5 class="card-header">{{ trans('vars.addon_params') }}</h5>
                    <div class='card-body text-primary'>
                        <h6 class="card-subtitle mb-2 text-muted">{{ trans('vars.addon_info') }}</h6>
                        <form method="post" action="{{ url('/build') }}" class="needs-validation" novalidate>
                            {{ csrf_field() }}
                            <div class="mb-3">
                            <label for="project_name" class="form-label">{{ trans('vars.project_name') }}</label>
                                <select id="project_name" class="form-select" aria-label="Default select example" name="addon_data[project_name]">
                                    @foreach($all_projects as $project)
                                        <option value="{{ $project }}" @if(isset($addon_data['project_name']) && $addon_data['project_name'] == $project)selected @endif>{{ $project }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">{{ trans('vars.project_name_info') }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="addon_id" class="form-label">{{ trans('vars.addon_id') }}</label>
                                <input type="text" class="form-control" id="addon_id" name="addon_data[id]" placeholder="{{ trans('vars.addon_placeholder') }}" required>
                                <div class="form-text">{{ trans('vars.addon_id_info') }}</div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="addon_version" class="form-label">{{ trans('vars.addon_version') }}</label>
                                    <input type="text" class="form-control" id="addon_version" name="addon_data[version]" value="1.0">
                                    <div class="form-text">{{ trans('vars.addon_version_info') }}</div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="addon_version" class="form-label">{{ trans('vars.addon_priority') }}</label>
                                    <input type="text" class="form-control" id="addon_version" 
                                            name="addon_data[priority]" value="@if(isset($addon_data['priority'])){{ $addon_data['priority'] }}@else 900 @endif">
                                    <div class="form-text">{{ trans('vars.addon_priority_info') }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="addon_position" class="form-label">{{ trans('vars.addon_position') }}</label>
                                    <input type="text" class="form-control" id="addon_position" 
                                            name="addon_data[position]" value="@if(isset($addon_data['position'])){{ $addon_data['position'] }}@else 100 @endif">
                                    <div class="form-text">{{ trans('vars.addon_position_info') }}</div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="addon_status" class="form-label">{{ trans('vars.addon_status') }}</label>
                                        <select id="project_name" class="form-select" aria-label="Default select example" name="addon_data[status]">
                                            <option value="acrive">{{ trans('vars.addon_status_active') }}</option>
                                            <option value="acrive">{{ trans('vars.addon_status_disabled') }}</option>
                                        </select>
                                    <div class="form-text">{{ trans('vars.addon_status_info') }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3 mb-3">
                                    <div class="form-check">
                                        <input type="hidden" value="N" name="addon_data[func]">
                                        <input class="form-check-input" name="addon_data[func]" type="checkbox" value="Y" id="func_file" checked>
                                        <label class="form-check-label" for="func_file">{{ trans('vars.func_file') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div class="form-check">
                                        <input type="hidden" value="N" name="addon_data[init]">
                                        <input class="form-check-input" name="addon_data[init]" type="checkbox" value="Y" id="init_file" checked>
                                        <label class="form-check-label" for="init_file">{{ trans('vars.init_file') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <div class="form-check">
                                        <input type="hidden" value="N" name="addon_data[config]">
                                        <input class="form-check-input" name="addon_data[config]" type="checkbox" value="Y" id="config_file" >
                                        <label class="form-check-label" for="config_file">{{ trans('vars.config_file') }}</label>
                                    </div>
                                </div>
                            </div>



                            <button type="submit" id="form_button" class="btn btn-primary">{{ trans('vars.addon_generate') }}</button>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent border-primary">{{ trans('vars.addons_footer') }}</div>
                </div>
            </div>
            <div class="col-sm-6 border-primary card">
                <div class='card-body text-primary'>
                    @if(!empty($addon_results))
                        <ul>
                            @foreach($addon_results as $file => $result)
                                <li>
                                    @if($result === true)
                                        <div class="alert alert-success" role="alert">
                                            <span>{{ trans('vars.addons_success') }}</span>
                                            <div>{{ $file }}</div>
                                        </div>
                                    @else
                                        <div class="alert alert-danger" role="alert">
                                            <span>{{ trans('vars.addons_danger') }}</span>
                                            <span>{{ $file }}</span>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-dark" role="alert">
                            <span>{{ trans('vars.empty_info') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{--<script>
    $('#form_button').on('click', function(event) {
        var addon_id = $('#addon_id').val();
        if (!addon_id) {
            $('#addon_id').addclass('');
            event.preventDefault();
        }
    });

    </script>--}}

@endsection

