<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\RecentlyView;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sortOptions = [
            'name_asc' => 'Product Name A-Z',
            'name_desc' => 'Product Name Z-A',
            'price_asc' => 'Price Low to High',
            'price_desc' => 'Price High to Low',
        ];

        $sortBy = $request->input('sort_by', 'name_asc');
        if (!in_array($sortBy, array_keys($sortOptions))) {
            $sortBy = 'name_asc';
        }

        $sortColumn = match ($sortBy) {
            'name_asc' => 'name',
            'name_desc' => 'name',
            'price_asc' => 'our_price',
            'price_desc' => 'our_price',
        };

        $sortOrder = match ($sortBy) {
            'name_asc' => 'asc',
            'name_desc' => 'desc',
            'price_asc' => 'asc',
            'price_desc' => 'desc',
        };

        $products = Product::orderBy($sortColumn, $sortOrder)->paginate(1);

        $sessionId = session()->getId();
        $recentlyViewedProducts = RecentlyView::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('products.index', compact('products', 'sortOptions', 'sortBy', 'recentlyViewedProducts'));
    }



    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required',
            'description' => 'required',
            'retail_price' => 'required|numeric',
            'our_price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload and store the file path
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        try {
            Product::create($validatedData);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to add the product.');
        }

        return redirect()->route('product.list')->with('success', 'Product added successfully.');
    }
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('product.list')->with('error', 'Product not found.');
        }
        $this->recordRecentlyViewedProduct($id);
        $sessionId = Session::getId();
        $recentlyViewedProducts = RecentlyView::with('product')
            ->where('session_id', $sessionId)
            ->where('product_id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('products.show', compact('product', 'recentlyViewedProducts'));
    }

    private function recordRecentlyViewedProduct($productId)
    {
        $sessionId = Session::getId();

        $recentlyViewedProduct = RecentlyView::where('product_id', $productId)
            ->where('session_id', $sessionId)
            ->first();

        if (!$recentlyViewedProduct) {

            RecentlyView::create([
                'product_id' => $productId,
                'session_id' => $sessionId,
            ]);
        }
    }
}
