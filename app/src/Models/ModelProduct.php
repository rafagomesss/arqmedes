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

    private function deleteAllProductCategories(int $id)
    {
        $sql = "DELETE FROM product_categories WHERE product_id = :id";
        $statement = $this->bind($sql, ['id' => $id]);
        $statement->execute();
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

    public function updateProductCategories(
        int $idProduct,
        array $categories
    ) {
        $this->deleteAllProductCategories($idProduct);
        if (!empty($categories)) {
            return $this->createProductWithCategory($idProduct, $categories);
        }
    }

    public function getProductWithCategories(int $id)
    {
        $sql = "
            SELECT
                p.*,
                group_concat(c.id separator ',') as categories_id,
                group_concat(c.name separator ',') as categories
            FROM products p
                LEFT JOIN product_categories pc ON pc.product_id = p.id
                LEFT JOIN categories c ON c.id = pc.category_id
            WHERE p.id = :id
                GROUP BY p.id
        ";
        $statement = $this->bind($sql, ['id' => $id]);
        $statement->execute();
        return $statement->fetch();
    }
}