<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Classes\AddonBuilder;

class IndexController extends Controller
{
    public function __construct()
    {
        App::setlocale('ru');
    }

    public function index()
    {
        $title = trans('vars.index_title');
        $all_projects = scandir(base_path() . '/..');
        foreach ($all_projects as $key => $value) {
            if (in_array($value, ['.', '..']) || (!file_exists(base_path() . '/../' . $value . '/app') || !file_exists(base_path() . '/../' . $value . '/config.local.php'))) {
                unset($all_projects[$key]);
            }
        }

        return view('index', [
            'all_projects' => $all_projects,
            'title' => $title,
        ]);
    }

    public function build (Request $request)
    {
        if ($request->has('addon_data.id') && $request->has('addon_data.project_name')) {
            $addon_data = $request->addon_data;
            $builder = new AddonBuilder(base_path() . '/../' . $addon_data['project_name'], $addon_data['id']);
            $builder->build();
        }

        return redirect()->route('home');
    }
}
