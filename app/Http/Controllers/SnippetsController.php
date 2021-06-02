<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SnippetsController extends Controller
{
    private $title = '';

    public function __construct()
    {
        App::setlocale('ru');
        
        //заголовок
        $this->title = trans('vars.snippets_title');
    }

    public function index()
    {
        //пока нет базы
        $constants = [
            'CART_LANGUAGE' => 'язык сессии',
            'DESCR_SL' => 'язык описаний мультиязычных сущностей',
            'CART_PRIMARY_CURRENCY' => 'основная валюта (в ней сохранены все прасы в db)',
            'CART_SECONDARY_CURRENCY' => 'выбранная валюта',
        ];

        $controller_returns = [
            'return [CONTROLLER_STATUS_OK];' => 'передача управления в вид',
            'return [CONTROLLER_STATUS_OK, \'products.manage\'];' => 'внутренний редирект',
            'return [CONTROLLER_STATUS_REDIRECT];' => 'прерывание и редирект',
            'return [CONTROLLER_STATUS_NO_PAGE];' => 'прерывание и 404',
            'return [CONTROLLER_STATUS_DENIED]' => 'прерывание и 403',
            'return [CONTROLLER_STATUS_NO_CONTENT]' => 'для ajax',
        ];

        return view('snippets', [
            'title' => $this->title,
            'constants' => $constants,
            'controller_returns' => $controller_returns,
        ]);
    }
}
