<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string',
            'category' => 'required|integer|in:1,2',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Set product details based on category
        $productDetails = $request->category == 1 ? 'Internet' : 'Internet + TV';

        // Create the order
        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'category' => $request->category,
            'product_details' => $productDetails,
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 200);
    }
    public function index()
    {
        // Fetch all orders from the database
        $orders = Order::all();

        // Return the orders as a JSON response
        return response()->json($orders);
    }
}
