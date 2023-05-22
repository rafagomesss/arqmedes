<?php

declare(strict_types=1);

namespace Arqmedes\Models;

use Arqmedes\Core\Model;

class ModelCategory extends Model
{
    protected $table = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategoriesByProduct(int $idProduct)
    {
        $sql = "";
    }
}