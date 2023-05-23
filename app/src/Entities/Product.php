<?php

declare(strict_types=1);

namespace Arqmedes\Entities;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Product
{
    public int $id;

    public function __construct(array $data)
    {
        $this->defineObject($data);
    }

    protected function defineObject($data)
    {
        $keys = array_keys($data);

        foreach ($keys as $key) {
            if ($key === 'price') {
                $this->$key = floatval(str_replace(',', '.', $data[$key]));
                continue;
            }
            if ($key === 'categories') continue;
            $this->$key = $key === 'id' ? intval($data[$key]) : $data[$key];
        }
    }
}
