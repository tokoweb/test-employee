<?php

namespace App\Validations\Api\Dashboard;

use App\Models\Product;

class ProductValidation
{
    /**
     * Show validation.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function show($request)
    {
        $result = [];
        $result['status'] = false;

        $validate = [
            'product_id' => ['required', 'exists:products,id'],
        ];

        $request->validate($validate);

        // Validation success
        $result['status'] = true;
        $result['message'] = 'Validation successfully !';

        $result = (object) $result;

        return $result;
    }

    /**
     * Store validation.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function store($request)
    {
        $result = [];
        $result['status'] = false;

        $validate = [
            'name' => ['required'],
            'price' => ['required'],
        ];

        $request->validate($validate);

        // Validation success
        $result['status'] = true;
        $result['message'] = 'Validation successfully !';

        $result = (object) $result;

        return $result;
    }

    /**
     * Update validation.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function update($request)
    {
        $result = [];
        $result['status'] = false;

        $validate = [
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required'],
            'price' => ['required'],
        ];

        $request->validate($validate);

        // Validation success
        $result['status'] = true;
        $result['message'] = 'Validation successfully !';

        $result = (object) $result;

        return $result;
    }

    /**
     * Update validation.
     *
     * @param  $id
     * @return  ArrayObject
     */
    public function destroy($id)
    {
        $result = [];
        $result['status'] = false;

        $product = Product::firstWhere('id', $id);

        if (empty($product)) {
            $result['message'] = 'ID produk tidak ditemukan !';
            $result = (object) $result;

            return $result;
        }

        // Validation success
        $result['status'] = true;
        $result['message'] = 'Validation successfully !';

        $result = (object) $result;

        return $result;
    }
}
