<?php

declare(strict_types=1);

namespace Arqmedes\Models;

use Arqmedes\Core\Model;

class ModelProduct extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    public function createProductWithCategory(
        int $idProduct,
        array $categories
    ) {
        $values = [];
        foreach ($categories as $category) {
            $values[] = "($idProduct, $category)";
        }
        $values = implode(", ", $values);
        $sql = "INSERT INTO product_categories VALUES $values";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}