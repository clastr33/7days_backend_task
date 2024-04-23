<?php

namespace Domain\Post;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $title
     * @param string $content
     * @return void
     */
    public function addPost(string $title, string $content): void
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $this->em->persist($post);
        $this->em->flush();
    }

    /**
     * @param int $id
     * @return Post
     */
    public function findPost(int $id): Post
    {
        return $this->em->getRepository(Post::class)->findOneBy(['id' => $id]);
    }
}
