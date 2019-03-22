<?php
/**
 * Created by PhpStorm.
 * User: sanny4rich
 * Date: 22.03.19
 * Time: 16:29
 */

namespace App\Service;


use App\Repository\CategoriesRepository;

class GetNamesFromRepository
{
    private $categoryRepository;
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoryRepository = $categoriesRepository;
    }

    function getName($name){
        $arr = $this->categoryRepository->findBy([
            ['name' => $name ]
        ]);
        return $arr;
    }
}