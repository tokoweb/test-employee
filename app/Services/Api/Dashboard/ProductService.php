<?php

namespace App\Services\Api\Dashboard;

use App\Models\Product;

class ProductService
{
    /**
     * Index service.
     *
     * @return  ArrayObject
     */
    public function index()
    {
        $product = Product::orderBy('name', 'asc')->get();

        $status = true;
        $message = 'Data retrieved successfully !';

        $result = (object) [
            'status' => $status,
            'message' => $message,
            'data' => $product,
        ];

        return $result;
    }

    /**
     * Show service.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function show($request)
    {
        $product = Product::firstWhere('id', $request->product_id);

        $status = true;
        $message = 'Data retrieved successfully !';

        $result = (object) [
            'status' => $status,
            'message' => $message,
            'data' => $product,
        ];

        return $result;
    }

    /**
     * Store service.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function store($request)
    {
        $data = [
            'name' => $request->name,
            'price' => $request->price,
        ];

        $filename = Product::saveImage($request);

        if ($filename) {
            $data['image'] = $filename;
        }

        $product = Product::create($data);

        $product = Product::firstWhere('id', $product->id);

        $status = true;
        $message = 'Data created successfully !';

        $result = (object) [
            'status' => $status,
            'message' => $message,
            'data' => $product,
        ];

        return $result;
    }

    /**
     * Update service.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function update($request)
    {
        $data = [
            'name' => $request->name,
            'price' => $request->price,
        ];

        $filename = Product::saveImage($request);

        if ($filename) {
            Product::deleteImage($request->product_id);
            $data['image'] = $filename;
        }

        $product = Product::where('id', $request->product_id)->update($data);

        $product = Product::firstWhere('id', $request->product_id);

        $status = true;
        $message = 'Data updated successfully !';

        $result = (object) [
            'status' => $status,
            'message' => $message,
            'data' => $product,
        ];

        return $result;
    }

    /**
     * Destroy service.
     *
     * @return  ArrayObject
     */
    public function destroy($id)
    {
        Product::deleteImage($id);
        Product::where('id', $id)->delete();

        $status = true;
        $message = 'Data deleted successfully !';

        $result = (object) [
            'status' => $status,
            'message' => $message,
        ];

        return $result;
    }
}
