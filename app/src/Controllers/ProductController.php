<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;
use Arqmedes\Core\Session\Flash;
use Arqmedes\Entities\Product;
use Arqmedes\Models\ModelCategory;
use Arqmedes\Models\ModelProduct;

class ProductController extends Controller
{
    protected string $activeController = 'produtos';

    private function productExists(int $id): bool
    {
        $product = (new ModelProduct())->find($id);
        if (!empty($product)) {
            return true;
        }
        return false;
    }

    public function index()
    {
        $data = [
            'produtos' => (new ModelProduct())->all(),
            'metodo' => 'index'
        ];
        return $this->render('modules/product/list', $data);
    }

    public function create()
    {
        $data = [
            'action' => 'Registrar',
            'categories' => (new ModelCategory())->all(),
        ];
        return $this->render('modules/product/create-update', $data);
    }

    public function store()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $data = array_filter($data, function ($item) {
            if (!empty($item)) return true;
        });

        if (empty($data) || count($data) < 4) {
            Flash::set('warning', 'Dados inválidos!');
            return $this->redirect('/produtos/cadastrar');
        }

        $product = new Product($data);
        $productCategories = $data['categories'] ?? null;
        $response = (new ModelProduct())->create($product);

        if ($response && $productCategories) {
            (new ModelProduct())->createProductWithCategory($response->id, $productCategories);
        }

        Flash::set('success', 'Produto <b>"' . $response->name . '"</b> cadastrado com sucesso!');
        return $this->redirect('/produtos');
    }

    public function show(int $id)
    {
        if (!$this->productExists($id)) {
            Flash::set('warning', 'Produto <u>não</u> encontrado!');
            return $this->redirect('/produtos');
        }

        $modelProduct = (new ModelProduct())->getProductWithCategories($id);
        $product = new Product((array) $modelProduct);
        $product->categories = explode(',', $modelProduct->categories ?? 'Nenhuma categoria cadastrada para o produto');

        $data = [
            'product' => $product
        ];

        return $this->render('modules/product/show', $data);
    }

    public function edit(int $id)
    {
        if (!$this->productExists($id)) {
            Flash::set('warning', 'Produto <u>não</u> encontrado!');
            return $this->redirect('/produtos');
        }

        $databaseProduct = (new ModelProduct())->getProductWithCategories($id);
        $product = new Product((array) $databaseProduct);
        $product->categories = explode(',', $product->categories_id ?? '');

        unset($product->categories_id);

        $categories = (new ModelCategory())->all();

        $data = [
            'product' => $product,
            'categories' => $categories,
            'action' => 'atualizar',
        ];
        return $this->render('modules/product/create-update', $data);
    }

    public function delete(int $id)
    {
        $type = 'warning';
        $message = 'Produto não encontrado!';

        if ($this->productExists($id)) {
            $type = 'success';
            $message = 'Produto <u>excluído</u> com sucesso!';
            (new ModelProduct())->delete($id);
        }

        Flash::set($type, $message);
        return $this->redirect('/produtos');
    }
}
