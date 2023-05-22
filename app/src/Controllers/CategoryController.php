<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;
use Arqmedes\Core\Session\Flash;
use Arqmedes\Entities\Category;
use Arqmedes\Models\ModelCategory;

class CategoryController extends Controller
{
    protected string $activeController = 'categorias';

    public function index()
    {
        $data = [
            'categories' => (new ModelCategory())->all(),
        ];
        return $this->render('modules/category/list', $data);
    }

    public function create()
    {
        $data = [
            'action' => 'Registrar',

        ];
        return $this->render('modules/category/create-update', $data);
    }

    public function store()
    {
        $data = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $category = new Category(['name' => $data]);
        $response = (new ModelCategory())->create($category);
        Flash::set('success', 'Categoria <b>"' . $response->name . '"</b> cadastrada com sucesso!');
        return $this->redirect('/categorias');
    }
}