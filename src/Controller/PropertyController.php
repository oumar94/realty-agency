<?php 
namespace App\Controller ;
use  Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PropertyRepository;

class PropertyController extends AbstractController
{

	
	/**
     * @var PropertyRepository
     */
 private $repository;
 public function __construct(PropertyRepository $repository)
 {
         	$this->repository=$repository;
  }

    /**
     * @Route("/properties",name="properties")
     */

	public function index()
	{
        $property=$this->repository->findAllVisible();
        dump($property);

          
		return $this->render('pages/property.html.twig',['current_menu'=>'properties']);
	}

	 /**
     * @Route("/properties/{slug}-{id}",name="property.show",requirements={"slug":"[a-z0-9\-]*"})
     */

	public function show($slug,$id)

	{
        $property=$this->repository->find($id);

		return $this->render('pages/show.html.twig',[

			'property'=>$property,
			'current_menu'=>'properties'


		   ]);
	}
}