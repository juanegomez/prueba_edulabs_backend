<?php

namespace App\Http\Services\Posts;

use App\Models\Posts;
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
}