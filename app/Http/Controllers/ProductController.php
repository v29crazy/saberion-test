<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\AttributeRepository;
use Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productRepository;
    protected $attributeRepository;

    public function __construct(ProductRepository $productRepository, AttributeRepository $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getProductsWithPagination($request);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }
    
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($request->all());
    
            $this->attributeRepository->createMany($product, $request->input('attributes'));

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollback();     
            return redirect()->back()->with('error', 'An error occurred while updating the product. Please try again.');
        }

    }
    
    public function show($id)
    {
        $product = $this->productRepository->findWithRelations($id);
        // Log::Info($product);
        return view('products.edit', compact('product'));
    }
    
    public function update($id, UpdateProductRequest $request)
    {

        DB::beginTransaction();
        try {

            $product = $this->productRepository->find($id);

            if (empty($product)) {
                return redirect()->route('products.show')->with('error', 'Product cannot find');
            }
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $request->image= $imagePath;
            }
            if (!isset($request->is_delivery_available)) {
                $request->is_delivery_available= 0;
            }
            $input = $request->all();
    
            $product = $this->productRepository->update($input, $id);
    
            $product->attributes()->delete();
            foreach ($request->input('attributes') as $attributeData) {
                $product->attributes()->create($attributeData);
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollback();     
            return redirect()->route('products.show')->with('error', $e->getMessage());
        }
    

    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->find($id);

            if (empty($product)) {
                return redirect()->route('products.index')->with('error', 'Product cannot find');
            }

            $product->delete();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();     
            return redirect()->route('products.show')->with('error', $e->getMessage());
        }
    }
}
