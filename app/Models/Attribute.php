<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Attribute extends Model
{
    use HasFactory;
    
    public $table = 'attributes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'product_id',
        'name',
        'attribute_value'
    ];
    
    public function created_user()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
    
    public function createMany($product, $attributes)
    {
        $attributesData = [];
        
        foreach ($attributes as $attribute) {
            
            $attributesData[] = [
                'name' => $attribute['name'],
                'attribute_value' => $attribute['attribute_value'],
                'product_id' => $product->id,
            ];
        }

        return Attribute::insert($attributesData);
    }
}
