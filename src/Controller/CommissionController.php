<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Form\CommissionFormType;
use App\Repository\CommissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    /**
     * @Route("/commissions", name="commission_list")
     */
    public function list(CommissionRepository $commissionRepository): Response
    {
        $commissions = $commissionRepository->findAll();
        return $this->render('commission/list.html.twig', ['commissions' => $commissions]);
    }

    /**
     * @Route("/commissions/create", name="commission_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $commission = new Commission();
        $form = $this->createForm(CommissionFormType::class, $commission);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commission);
            $em->flush();
            return $this->redirectToRoute('commission_list');
        }

        return $this->render('commission/create.html.twig', ['form' => $form->createView()]);
    }
}


?>