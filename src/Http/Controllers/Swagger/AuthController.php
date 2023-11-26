<?php

namespace Dcat\Admin\Http\Controllers\Swagger;

use OpenApi\Attributes as OA;
use Illuminate\Routing\Controller;

/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register Account",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Some username"),
 *                     @OA\Property(property="email", type="string", example="someEmail@gmail.com"),
 *                     @OA\Property(property="password", type="string", example="1a3t5u7p"),
 *                     @OA\Property(property="password_confirmation", type="string", example="1a3t5u7p"),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 * ),
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Log In",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", example="someEmail@gmail.com"),
 *                     @OA\Property(property="password", type="string", example="1a3t5u7p"),
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="access_token", type="string", example="1|d520bcb82824a2638d7d63227d12daa51fde616da52be55af248d6b683009821"),
 *                 @OA\Property(property="token_type", type="string", example="Bearer"),
 *             ),
 *         ),
 *     ),
 * ),
 *
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Log Out",
 *     tags={"Auth"},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     ),
 * ),
 */
class AuthController extends Controller
{
    //
}
