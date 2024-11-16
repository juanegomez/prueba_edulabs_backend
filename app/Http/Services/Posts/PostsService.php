<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostsService
{
    /**
     * Registra un nuevo post
     *
     * @param array $postData
     * @return \App\Models\Posts
     */
    public function register(array $postData)
    {
        // Validar los datos para la creación del post
        $validator = Validator::make($postData, [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Crear el post
        $post = Posts::create([
            'title' => $postData['title'],
            'content' => $postData['content'],
            'category_id' => $postData['category_id'],
            'user_id' => $postData['user_id'],
        ]);

        return $post;
    }

    /**
     * Obtener post por usuario y categoría
     *
     * @param array $params
     * @return \App\Models\Posts
     */
    public function getPostByCategoryAndUserId(int $category_id): Collection
    {
        // Validar el category_id
        $validator = Validator::make(['category_id' => $category_id], [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Obtener los posts por category_id
        $posts = Posts::byCategory($category_id)->get();

        return $posts;
    }
}