<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'products';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'code',
        'category',
        'name',
        'description',
        'selling_price',
        'special_price',
        'status',
        'is_delivery_available',
        'image'
    ];
    

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    
    public function findWithRelations($id)
    {
        return Product::with('attributes')->find($id);
    }

    public function getProductsWithPagination($request){
        
        $query = Product::query();

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);
    
        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('code', 'like', "%$search%");
        }
    
        return $query->paginate(10);
    }
}