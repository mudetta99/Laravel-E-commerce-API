<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    
    // Fetch all products
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'message' => 'All Products',
            'data' => $products
        ]);
    }
    

    // Store a new product
    public function store(Request $request, Product $product)
    {
        // Validate incoming request data
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'fail' => false,
                'message' => 'Can not store product',
                'error' => $validator->errors()
            ]);
        }
    
        // Create and store a new product
        $product = Product::create($input);
    
        // Return success response with the new product
        return response()->json([
            'success' => true,
            'message' => 'Product Added Successfully',
            'data' => $product
        ]);
    }

    
    // Fetch a specific product by ID
    public function show($id)
    {
        // Find the product by ID
        $product = Product::find($id);
    
        // Check if product exists
        if (is_null($product))
        {
            // If product not found, return error response
            return response()->json([
                'fail' => true,
                'message' => 'Sorry, Product not found',
            ], 404);
        }
    
        // Return success response with the product
        return response()->json([
            'success' => true,
            'message' => 'Product Fetched Successfully',
            'data' => $product
        ]);
    }
    

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        // Validate incoming request data
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        // Check if validation fails
        if ($validator->fails())
        {
            // If validation fails, return error response
            return response()->json([
                'fail' => false,
                'message' => 'Sorry, Product not updated',
                'error' => $validator->errors()
            ]);
        }

        
        // Update product details
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->save();

        // Return success response with the updated product
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }


    // Delete a product
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
            'data' => $product
        ]);
    }

}
