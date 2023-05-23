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

    private function categoryExists(int $id): bool
    {
        $product = (new ModelCategory())->find($id);
        if (!empty($product)) {
            return true;
        }
        return false;
    }

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

    public function edit(int $id)
    {
        if (!$this->categoryExists($id)) {
            Flash::set('warning', 'Categoria <u>não</u> encontrado!');
            return $this->redirect('/categorias');
        }

        $databaseCategory = (new ModelCategory())->find($id);
        $category = new Category((array) $databaseCategory);

        $data = [
            'category' => $category,
            'action' => 'atualizar',
        ];
        return $this->render('modules/category/create-update', $data);
    }

    public function delete(int $id)
    {
        $type = 'warning';
        $message = 'Categoria não encontrada!';

        if ($this->categoryExists($id)) {
            $type = 'success';
            $message = 'Categoria <u>excluída</u> com sucesso!';
            (new ModelCategory())->delete($id);
            $modelCategory = (new ModelCategory());
            $modelCategory->delete($id);
            $modelCategory->deleteRelations($id);
        }

        Flash::set($type, $message);
        return $this->redirect('/categorias');
    }

    public function update()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (
            empty($data['id'])
            || !$this->categoryExists(intval(trim($data['id'])))
        ) {
            Flash::set('warning', 'Categoria <u>não</u> encontrada!');
            return $this->redirect('/categorias');
        }

        $category = new Category($data);
        $response = (new ModelCategory())->update($category);
        $type = 'success';
        $message = 'Categoria <b>"' . $response->name . '"</b> atualizada com sucesso!';
        if (empty($response)) {
            $type = 'warning';
            $message = 'Falha ao atualizar a categoria! Tente novamente.';
        }
        Flash::set($type, $message);
        return $this->redirect('/categorias');
    }
}