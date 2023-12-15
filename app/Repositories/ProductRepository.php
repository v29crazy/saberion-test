<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'name'
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Product::class;
    }

    public function findWithRelations($id)
    {
        return $this->model->findWithRelations($id);
    }

    public function getProductsWithPagination($id)
    {
        return $this->model->getProductsWithPagination($id);
    }
}
