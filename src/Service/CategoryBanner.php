<?php

namespace App\Service;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryBanner
{

    private $session;

    private $categoryRepository;

    public function __construct(
        CategoriesRepository $categoriesRepository,
        Session $session)
    {

        $this->categoryRepository = $categoriesRepository;
        $this->session = $session;
    }

    /**
     * @return Categories[]
     */
    public function saveCategoriesToSession()
    {
        if (!$this->session->has('categories')) {
            $Categories = $this->categoryRepository->findAll();
            $this->session->set('categories', $Categories);
        }

        return $this->session->get('categories');
    }


}