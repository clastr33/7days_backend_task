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
            $this->addFlash('formData', $formData);

            return $this->redirectToRoute('app_success');
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
        $formData = $this->get('session')->getFlashBag()->get('formData')[0];

        $inputDate = $formData['date'];
        $inputTimezone = $formData['timezone'];

        $date = new \DateTime($inputDate);

        // Offset In Minutes
        $timezone = new \DateTimeZone($inputTimezone);
        $offsetSeconds = $timezone->getOffset(new \DateTime());
        $offsetMinutes = $offsetSeconds / 60;
        $offsetMinutes = $offsetMinutes > 0 ? '+' . $offsetMinutes : $offsetMinutes;

        // February Length
        $currentYear = (int) date($inputDate);
        $february = new \DateTime("$currentYear-02-01");
        $februaryLength = (int) $february->format('t');

        return $this->render('form/success.html.twig', [
            'inputTimezone' => $inputTimezone,
            'offsetMinutes' => $offsetMinutes,
            'februaryLength' => $februaryLength,
            'monthName' => $date->format('F'),
            'monthLength' => (int)$date->format('t'),
        ]);
    }
}
