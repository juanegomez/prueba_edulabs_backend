<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Http\Services\Posts\PostsService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    /**
     * Registrar un post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        try {
            //Obtener el ID del usuario autenticado
            $userId = auth()->user()->id ?? 0;

            $data = $request->all();
            $data['user_id'] = $userId;

            $post = $this->postsService->register($data);

            return response()->json([
                'post' => new PostResource($post),
                'message' => 'Publicación registrado exitosamente',
                'success' => true,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Obtener post por usuario y categoría
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPostByCategoryAndUserId($category_id)
    {
        try {
            $posts = $this->postsService->getPostByCategoryAndUserId($category_id);

            return response()->json([
                'data' => PostsResource::collection($posts),
                'success' => true,
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
