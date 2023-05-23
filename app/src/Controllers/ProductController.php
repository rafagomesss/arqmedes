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
        $get = (new ModelProduct())->getProductWithCategories($id);
        $product = new Product((array) $get);
        $product->categories = explode(',', $get->categories ?? 'Nenhuma categoria cadastrada para o produto');
        $data = [
            'product' => $product
        ];
        return $this->render('modules/product/show', $data);
    }

    public function edit(int $id)
    {
        $databaseProduct = (new ModelProduct())->getProductWithCategories($id);
        $product = new Product((array) $databaseProduct);
        $product->categories = explode(',', $product->categories_id);
        unset($product->categories_id);
        $categories = (new ModelCategory())->all();
        $data = [
            'product' => $product,
            'categories' => $categories,
            'action' => 'Editar',
        ];
        return $this->render('modules/product/create-update', $data);
    }

    public function delete(int $id)
    {
        $product = (new ModelProduct())->find($id);
        $type = 'warning';
        $message = 'Produto não encontrado!';
        if (!empty($product)) {
            $type = 'success';
            $message = 'Produto <b>"' . $product->name . '"</b> excluído com sucesso!';
            (new ModelProduct())->delete($product->id);
        }
        Flash::set($type, $message);
        return $this->redirect('/produtos');
    }
}
