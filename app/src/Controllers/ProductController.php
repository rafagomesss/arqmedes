<?php

declare(strict_types=1);

namespace Arqmedes\Controllers;

use Arqmedes\Core\Controller;
use Arqmedes\Entities\Product;
use Arqmedes\Models\ModelProduct;

class ProductController extends Controller
{
    public function index()
    {
        $data = [
            'produtos' => (new ModelProduct())->all(),
        ];
        return $this->render('modules/product/list', $data);
    }

    public function create()
    {
        $data = [
            'action' => 'Registrar',

        ];
        return $this->render('modules/product/create-update', $data);
    }

    public function store()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $product = new Product($data);
        $productCategories = $data['categories'];
        $response = (new ModelProduct())->create($product);
        (new ModelProduct())->createProductWithCategory(1, $productCategories);

        // echo '<pre>' . print_r($product, true) . '</pre>';
        // exit();
        // echo '<pre>' . print_r($response, true) . '</pre>';
        // exit();
    }
}
