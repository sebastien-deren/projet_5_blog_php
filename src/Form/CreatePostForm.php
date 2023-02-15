<?php

namespace Blog\Form;

use Blog\DTO\Post\CreatePostDTO;
use Exception;

class CreatePostForm
{


    public function ArrayToObjectPostCreationDTO($data): CreatePostDTO
    {
        $postCreation = new CreatePostDTO;
        if (empty($data['title'])) {
            throw new \Exception("pas de titre");
        }
        if (empty($data['excerpt'])) {
            throw new  Exception("pas de résumé");
        }
        if (empty($data['content'])) {
            throw new Exception("pas de contenu");
        }
        $postCreation->content = \htmlspecialchars($data['content']);
        $postCreation->excerpt = \htmlspecialchars($data['excerpt']);
        $postCreation->title = \htmlspecialchars($data['title']);

        return $postCreation;
    }
}
