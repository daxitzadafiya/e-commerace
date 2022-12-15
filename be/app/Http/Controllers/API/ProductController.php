<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    
    /**
     * Get Products List
     * @OA\Get (
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"jwt":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="name"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         example="image"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="description"
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="float",
     *                         example="500.00"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="datetime",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="datetime",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
    */

    public function index()
    {
        $response['products'] = Product::get();

        return $this->sendResponse($response, 'fetch all products successfully.');
    }

    /**
        * @OA\Post(
        * path="/api/products",
        * operationId="Products",
        * tags={"Products"},
        * summary="Add Products",
        * security={{"jwt":{}}},
        * description="Add Products here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name", "image", "description", "price"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(
        *                   property="image",
        *                   description="Product Image",
        *                   type="file",
        *               ),
        *               @OA\Property(property="description", type="text"),
        *               @OA\Property(property="price", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Products Added Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Products Added Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
    */

    public function store(ProductStoreRequest $request)
    {

        $data = $request->validated();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products',['disk' => 'public']);
        }

        $response['product'] = Product::create($data);

        return $this->sendResponse($response, 'Product added successfully.');
    }

    /**
     * Get Product Detail
     * @OA\Get (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="price", type="number"),
     *              @OA\Property(property="created_at", type="datetime"),
     *              @OA\Property(property="updated_at", type="datetime")
     *         )
     *     )
     * )
    */

    public function show($id)
    {
        $response['product'] = Product::find($id);

        return $this->sendResponse($response, 'Product fetched successfully.');
    }

    /**
     * Update Product
     * @OA\Put (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(
     *                          property="image",
     *                          type="string",
     *                      ),
     *                      @OA\Property(property="description", type="string"),
     *                      @OA\Property(property="price", type="number"),
     *                 ),
     *                 example={
     *                     "name":"XYZ",
     *                     "image":"/home/pd/Documents/Images/photo8.jpg",
     *                     "description":"Test description",
     *                     "price":1200   
     *                 }
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="image", type="string", example="/home/pd/Documents/Images/photo8.jpg"),
     *              @OA\Property(property="description", type="string", example="Test description"),
     *              @OA\Property(property="price", type="number", example="500"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
    */

    public function update(ProductUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $product = Product::find($id);

        if($request->hasFile('image') && isset($product->image))
        {
            Storage::delete('public/'.$product->image);
        }

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products',['disk' => 'public']);
        }

        $product->update($data);

        $response['product'] = Product::find($id);

        return $this->sendResponse($response, 'Product updated successfully.');
    }

    /**
     * Delete Products
     * @OA\Delete (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"jwt":{}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Products deleted successfully")
     *         )
     *     )
     * )
    */
    
    public function destroy($id)
    {
        $product = Product::find($id);
        if(isset($product->image)) {
            Storage::delete('public/'.$product->image);
        }
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}