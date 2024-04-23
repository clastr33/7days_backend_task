<?php

namespace App\Controller;

use App\Form\TimeZoneFormType;
use App\Service\TimeCountService;
use DateTime;
use Exception;
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

            return $this->redirectToRoute('app_success', [
                'inputDate' => $formData['date'],
                'inputTimezone' => $formData['timezone'],
            ]);
        }

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     * @Route("/success", name="app_success")
     */
    public function success(Request $request): Response
    {
        $date = new DateTime($request->get('inputDate'));

        return $this->render('form/success.html.twig', [
            'inputTimezone' => $request->get('inputTimezone'),
            'offsetMinutes' => $this->timeCountService->offsetInMinutes($request->get('inputTimezone')),
            'februaryLength' => $this->timeCountService->februaryLength($request->get('inputDate')),
            'monthName' => $date->format('F'),
            'monthLength' => (int)$date->format('t'),
        ]);
    }
}
