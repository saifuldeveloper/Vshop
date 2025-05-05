<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\productResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductListController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'product_images');
        $filterProducts = $products->filtered()->paginate(9)->withQueryString();

        $categories = Category::get();
        $brands = Brand::get();
        
        return Inertia::render(
            'Frontend/ProductList',
            [
                'categories'=>$categories,
                'brands'=>$brands,
                'products' => productResource::collection($filterProducts)
            ]
        );
    }
}
