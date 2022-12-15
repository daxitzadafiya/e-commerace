<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantStoreRequest;
use App\Http\Requests\ProductVariantUpdateRequest;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * Get Product Variants List
     * @OA\Get (
     *     path="/api/product-variants",
     *     tags={"Product Variant"},
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
     *                         property="product_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="color",
     *                         type="string",
     *                         example="red"
     *                     ),
     *                     @OA\Property(
     *                         property="size",
     *                         type="string",
     *                         example="XL"
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
        $response= ProductVariant::leftJoin('products', 'products_variants.product_id','=', 'products.id')
        ->select('products_variants.*', 'products.name', 'products.image', 'products.description', 'products.price')
        ->get();
        // $response['product_variants'] = ProductVariant::get();

        return $this->sendResponse($response, 'fetch all product variants successfully.');
    }

    /**
     * @OA\Post(
     * path="/api/product-variants",
     * operationId="Product Variant",
     * tags={"Product Variant"},
     * summary="Add Product Variants",
     * security={{"jwt":{}}},
     * description="Add Product Variant here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"product_id", "color", "size"},
     *               @OA\Property(property="product_id", type="number"),
     *               @OA\Property(property="color", type="text"),
     *               @OA\Property(property="size", type="text"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Product Variants Added Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Product Variants Added Successfully",
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

    public function store(ProductVariantStoreRequest $request)
    {
        $data = $request->validated();
        $response['product_variant'] = ProductVariant::create($data);

        return $this->sendResponse($response, 'Product Variant added successfully.');
    }

    /**
     * Get Product Variant Detail
     * @OA\Get (
     *     path="/api/product-variants/{id}",
     *     tags={"Product Variant"},
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
     *              @OA\Property(property="product_id", type="number"),
     *              @OA\Property(property="color", type="string"),
     *              @OA\Property(property="size", type="string"),
     *              @OA\Property(property="created_at", type="datetime"),
     *              @OA\Property(property="updated_at", type="datetime")
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        $response['product_variant'] = ProductVariant::find($id);

        return $this->sendResponse($response, 'Product Variant fetched successfully.');
    }

    /**
     * Update Product Variant
     * @OA\Put (
     *     path="/api/product-variants/{id}",
     *     tags={"Product Variant"},
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
     *                      @OA\Property(property="product_id", type="number"),
     *                      @OA\Property(property="color", type="string"),
     *                      @OA\Property(property="size", type="string"),
     *                 ),
     *                 example={
     *                     "product_id":1,
     *                     "color":"red",
     *                     "size":"XL",
     *                 }
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="product_id", type="number", example="1"),
     *              @OA\Property(property="color", type="string", example="red"),
     *              @OA\Property(property="size", type="string", example="XL"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
     */

    public function update(ProductVariantUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $product_variant = ProductVariant::find($id);

        $product_variant->update($data);

        $response['product_variant'] = ProductVariant::find($id);

        return $this->sendResponse($response, 'Product Variant updated successfully.');
    }

    /**
     * Delete Product Variant
     * @OA\Delete (
     *     path="/api/product-variants/{id}",
     *     tags={"Product Variant"},
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
     *             @OA\Property(property="msg", type="string", example="Product Variant deleted successfully")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $product_variant = ProductVariant::find($id);

        $product_variant->delete();

        return $this->sendResponse([], 'Product Variant deleted successfully.');
    }
}
