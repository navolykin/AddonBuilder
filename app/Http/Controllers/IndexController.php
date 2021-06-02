<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Classes\AddonBuilder;

class IndexController extends Controller
{
    private $title = '';

    public function __construct()
    {
        App::setlocale('ru');

        //заголовок страницы
        $this->title = trans('vars.index_title');
    }

    public function index()
    {
        //все проекты, которые удалось найти
        $all_projects = scandir(base_path() . '/..');
        foreach ($all_projects as $key => $value) {
            if (in_array($value, ['.', '..']) || (!file_exists(base_path() . '/../' . $value . '/app') || !file_exists(base_path() . '/../' . $value . '/config.local.php'))) {
                unset($all_projects[$key]);
            }
        }

        //значени по умолчанию, если есть, тянутся из сессии (предыдущий запрос)
        $addon_data = Session::get('addon_data', []);

        //результат создания модуля
        $addon_results = Session::get('addon_results', []);

        return view('index', [
            'all_projects' => $all_projects,
            'title' => $this->title,
            'addon_data' => $addon_data,
            'addon_results' => $addon_results,
        ]);
    }

    public function build (Request $request)
    {
        $this->validate($request, [
            'addon_data.id' => 'required',
            'addon_data.project_name' => 'required',
        ]);

        $addon_data = $request->addon_data;

        //пишем в сессию
        Session::put('addon_data', $addon_data);

        //создаем файлы модуля
        $builder = new AddonBuilder(base_path() . '/../' . $addon_data['project_name'], $addon_data['id'], $addon_data);
        $result = $builder->build();

        Session::flash('addon_results', $result);


        return redirect()->route('home');
    }
}
