<?php

namespace App\Controller;

use App\Form\TimeZoneFormType;
use App\Service\TimeCountService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    private TimeCountService $timeCountService;
    public function __construct(TimeCountService $timeCountService)
    {
        $this->timeCountService = $timeCountService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/form", name="app_form")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TimeZoneFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $this->addFlash('formData', $formData);

            return $this->redirectToRoute('app_success');
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("/success", name="app_success")
     */
    public function success(): Response
    {
        $formData = $this->get('session')->getFlashBag()->get('formData')[0];
        $inputDate = $formData['date'];
        $inputTimezone = $formData['timezone'];

        $date = new DateTime($inputDate);

        return $this->render('form/success.html.twig', [
            'inputTimezone' => $inputTimezone,
            'offsetMinutes' => $this->timeCountService->offsetInMinutes($inputTimezone),
            'februaryLength' => $this->timeCountService->februaryLength($inputDate),
            'monthName' => $date->format('F'),
            'monthLength' => (int)$date->format('t'),
        ]);
    }
}
