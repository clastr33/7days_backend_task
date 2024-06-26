<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Domain\Post\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @param PostRepository $postRepository
     * @return Response
     * @Route("/", name="app_post_index")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['id' => 'desc'], 100);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @param PostManager $postManager
     * @param int $id
     * @return Response
     * @Route("/post/{id}", name="app_post_show")
     */
    public function show(PostManager $postManager, int $id): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $postManager->findPost($id),
        ]);
    }
}
