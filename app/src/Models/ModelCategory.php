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

    public function deleteRelations(int $id)
    {
        $sql = "";
        $sql = "DELETE FROM product_categories WHERE category_id = :id";
        $statement = $this->connection->prepare($sql);
        $statement = $this->bind($sql, ['id' => $id]);
        return $statement->execute();
    }
}
