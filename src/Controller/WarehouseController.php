<?php

namespace App\Controller;

use App\Entity\Bricks;
use App\Form\AddBricksType;
use App\Form\SellBricksType;
use App\Repository\BricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/warehouse", name="warehouse.")
 */

class WarehouseController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param BricksRepository $bricksRepository
     * @return Response
     */
    public function index(BricksRepository $bricksRepository)
    {
        $bricks = $bricksRepository->findAll();

        return $this->render('warehouse/index.html.twig', [
            'bricks' => $bricks
        ]);
    }

    /**
     * @Route("/store", name="store")
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $bricks = new Bricks();

        $form = $this->createForm(AddBricksType::class, $bricks);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($bricks);
            $em->flush();

            $this->addFlash('success', 'Operation done successfully');
            return $this->redirect($this->generateUrl('warehouse.index'));
        }

        return $this->render('warehouse/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pull", name="pull")
     * @param Request $request
     * @return Response
     */
    public function pull(Request $request)
    {
        $form = $this->createForm(SellBricksType::class);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $bricks = $em->getRepository(Bricks::class)->findBy(array(), array('stored_date' => 'ASC'));
            $bricksWarehouse = 0;
            $earned = 0;

            // Check if we have enough bricks in the warehouse
            foreach ($bricks as $key => $value)
            {
                $bricksWarehouse += $value->getAmount();
            }

            $amount = $form->get('amount')->getData();

            // If we dont have enough bricks display danger message
            if($bricksWarehouse < (int)$amount)
            {
                $this->addFlash('danger', 'We dont have enough bricks');
            }
            else
            {
                foreach ($bricks as $key => $value)
                {
                    $brick = $em->getRepository(Bricks::class)->find($value->getId());

                    if($amount > $brick->getAmount()) {
                        $amount = $amount - $brick->getAmount();
                        $earned += $brick->getPrice() * $brick->getAmount();
                        $em->remove($brick);
                        $em->flush();
                    }
                    else {
                        $brick->setAmount($brick->getAmount() - $amount);
                        $em->persist($brick);
                        $em->flush();
                        $earned += $brick->getPrice() * $amount;

                        if($brick->getAmount() == 0)
                        {
                            $em->remove($brick);
                            $em->flush();
                        }

                        break;
                    }
                }

                $this->addFlash('success', 'Operation done successfully. Earned: '. $earned .' zl');
                return $this->redirect($this->generateUrl('warehouse.index'));
            }
        }

        return $this->render('warehouse/sell.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
