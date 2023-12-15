<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\BaseRepository;

class AttributeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Attribute::class;
    }

    public function createMany($product, $attributes)
    {
        return $this->model->createMany($product, $attributes);
    }
}
