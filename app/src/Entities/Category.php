<?php

declare(strict_types=1);

namespace Arqmedes\Entities;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Category
{
    public function __construct(array $data)
    {
        $this->defineObject($data);
    }

    protected function defineObject($data)
    {
        $keys = array_keys($data);

        foreach ($keys as $key) {
            $this->$key = $data[$key];
        }

    }
}
