<?php 
namespace App\Controller ;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Knp\Component\Pager\PaginatorInterface;
use  Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

	public function index(PaginatorInterface $paginator,Request $request)
	{
	    $search=new PropertySearch();
	    $form=$this->createForm(PropertySearchType::class,$search);
	    $form->handleRequest($request);

        $properties=$paginator->paginate($this->repository->findAllVisibleQuery($search), $request->query->getInt('page', 1),12);

		return $this->render('pages/property.html.twig',[
		    'properties'=>$properties,
            'form'=>$form->createView()

           ]);
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