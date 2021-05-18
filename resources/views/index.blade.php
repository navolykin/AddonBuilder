<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>AddonBuilder v1.0</title>
</head>

<body>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link " href="#">Создать модуль</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Посмотреть сниппеты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Ссылки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">О приложении</a>
        </li>
    </ul>
    <div class="container">
        <div class="col-sm-6 border-primary card">
            <h5 class="card-header">Параметры модуля</h5>
            <div class='card-body text-primary'>
                <h6 class="card-subtitle mb-2 text-muted">Укажите основные параметры модуля</h6>
                <form method="get" action="{{ url('/build') }}">
                    <div class="mb-3">
                    <label for="project_name" class="form-label">Project name</label>
                        <select id="project_name" class="form-select" aria-label="Default select example" name="addon_data[project_name]">
                            @foreach($all_projects as $project)
                                <option value="{{ $project }}">{{ $project }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInput" class="form-label">Addon ID</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="addon_data[id]" placeholder="cp_addon_name">
                        <div class="form-text">Введите ID модуля</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="card-footer bg-transparent border-primary">После подтверждения, создастся скелет модуля</div>
        </div>
        <div class="col-sm-6">
        </div>
    </div>

</body>

</html>
