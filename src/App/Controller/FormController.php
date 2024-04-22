<?php

namespace App\Controller;

use App\Form\TimeZoneFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="app_form")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TimeZoneFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            return $this->redirectToRoute('app_success', [

            ]);
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="app_success")
     */
    public function success(): Response
    {
        return $this->render('form/success.html.twig');
    }
}
