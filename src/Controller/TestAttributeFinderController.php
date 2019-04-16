<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestAttributeFinderController extends AbstractController
{
    /**
     * @Route("/test/attribute/finder", name="test_attribute_finder")
     */
    public function index()
    {
        return $this->render('test_attribute_finder/index.html.twig', [
            'controller_name' => 'TestAttributeFinderController',
        ]);
    }
}
