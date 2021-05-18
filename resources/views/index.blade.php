<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>{{ $title }}</title>
</head>

<body>

    <div class="container">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link " href="#">{{ trans('vars.menu_create_addon') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ trans('vars.menu_show_snippets') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ trans('vars.menu_links') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ trans('vars.menu_about') }}</a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="border-primary card">
                    <h5 class="card-header">{{ trans('vars.addon_params') }}</h5>
                    <div class='card-body text-primary'>
                        <h6 class="card-subtitle mb-2 text-muted">{{ trans('vars.addon_info') }}</h6>
                        <form method="get" action="{{ url('/build') }}">
                            <div class="mb-3">
                            <label for="project_name" class="form-label">{{ trans('vars.project_name') }}</label>
                                <select id="project_name" class="form-select" aria-label="Default select example" name="addon_data[project_name]">
                                    @foreach($all_projects as $project)
                                        <option value="{{ $project }}">{{ $project }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">{{ trans('vars.project_name_info') }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="addon_id" class="form-label">{{ trans('vars.addon_id') }}</label>
                                <input type="text" class="form-control" id="addon_id" name="addon_data[id]" placeholder="{{ trans('vars.addon_placeholder') }}">
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
                                    <input type="text" class="form-control" id="addon_version" name="addon_data[priority]" value="900">
                                    <div class="form-text">{{ trans('vars.addon_priority_info') }}</div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ trans('vars.addon_generate') }}</button>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent border-primary">{{ trans('vars.addons_footer') }}</div>
                </div>
            </div>
            <div class="col-sm-6 border-primary card">
                <div class='card-body text-primary'>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
