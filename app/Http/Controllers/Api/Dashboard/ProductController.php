<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Validations\Api\Dashboard\ProductValidation;
use App\Services\Api\Dashboard\ProductService;

class ProductController extends Controller
{
    /**
     * Validation instance.
     *
     * @var \App\Validations\Api\Dashboard\ProductValidation
     */
    protected $productValidation;

    /**
     * Service instance.
     *
     * @var \App\Services\Api\Dashboard\ProductService
     */
    protected $productService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(ProductValidation $productValidation, ProductService $productService)
    {
        $this->productValidation = $productValidation;
        $this->productService = $productService;
    }

    /**
     * Index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->productService->index();

        return $this->sendResponse($result);
    }

    /**
     * Show.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validation = $this->productValidation->show($request);

        if (!$validation->status) {
            return $this->sendResponse($validation);
        }

        $result = $this->productService->show($request);

        return $this->sendResponse($result);
    }

    /**
     * Store.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->productValidation->store($request);

        if (!$validation->status) {
            return $this->sendResponse($validation);
        }

        $result = $this->productService->store($request);

        return $this->sendResponse($result);
    }

    /**
     * Update.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = $this->productValidation->update($request);

        if (!$validation->status) {
            return $this->sendResponse($validation);
        }

        $result = $this->productService->update($request);

        return $this->sendResponse($result);
    }

    /**
     * Destroy.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validation = $this->productValidation->destroy($id);

        if (!$validation->status) {
            return $this->sendResponse($validation);
        }

        $result = $this->productService->destroy($id);

        return $this->sendResponse($result);
    }
}
