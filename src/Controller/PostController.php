<?php

// src/Controller/PostController.php
namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/post', name: 'post_index')]
    public function index(): Response
    {
        $posts = $this->entityManager->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/create', name: 'post_create')]
    public function create(Request $request): Response
    {
        $post = new Post();
        // Handle form submission and save new post...
        return $this->render('post/create.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/post/{id}', name: 'post_show')]
    public function show(int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/post/{id}/edit', name: 'post_edit')]
    public function edit(Request $request, int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);
        // Handle form submission and update post...
        return $this->render('post/edit.html.twig', [
            'post' => $post,
        ]);
    }
}



?>