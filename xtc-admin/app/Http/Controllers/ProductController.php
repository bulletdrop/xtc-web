<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Licenses;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LogController;

class ProductController extends Controller
{
    public static function store(Request $request)
    {
        $admin = SessionController::checkSession($request);
        if ($admin) {
            if (strlen($request->input('product_name')) < 3){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product name must be at least 3 characters'
                ]);
            }

            foreach (Products::all() as $product)
            {
                if ($product->product_name == $request->input('product_name'))
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product already exists'
                    ]);
            }

            $product = new Products;
            $product->product_name = $request->input('product_name');
            $product->file_name = $request->input('file_name');
            $product->save();

            LogController::writeLog($admin->username . " (" . $admin->aid . ") Added product with id: " . $product->pid);

            return response()->json([
                'status' => 'success',
                'message' => 'The product has been added',
                'id' => $product->pid
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in'
            ]);
        }
    }

    public static function delete(Request $request)
    {
        $admin = SessionController::checkSession($request);
        if ($admin) {
            foreach (Licenses::all() as $license)
            {
                if ($license->pid == $request->input('id'))
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product is in use'
                    ]);
            }

            $product = Products::where('pid', $request->input('id'))->first();
            if ($product) {

                LogController::writeLog($admin->username . " (" . $admin->aid . ") Deleted product with id: " . $product->pid);

                $product->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'The product has been deleted'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ]);
            }

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged in'
            ]);
        }
    }
}
