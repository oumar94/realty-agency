<?php
namespace  App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class  AdminPropertyController extends AbstractController
{
    /**
     *@ PropertyRepository
     */
    private $repository;
    /**
     *@
     */
    private $em;
    public function __construct(PropertyRepository $repository,EntityManagerInterface $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    /**
     * @Route("/admin",name="admin.property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request )
    {
        $properties=$paginator->paginate($this->repository->findAllQuery(), $request->query->getInt('page', 1),5);
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create",name="admin.property.new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $property=new Property();
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Bien creée avec success');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}",name="admin.property.edit",methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(Property $property,Request $request)
    {
        $form=$this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $this->em->flush();
            $this->addFlash('success','Bien modifié avec success');
            return $this->redirectToRoute('admin.property.index');
        }
        
        return $this->render('admin/property/edit.html.twig',[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}",name="admin.property.delete",methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function delete(Property $property,Request $request)
    {
        if($this->isCsrfTokenValid('delete', $property->getId(), $request->get('_token')))
        {

             $this->em->remove($property);
             $this->em->flush();
            $this->addFlash('success','Bien supprimé avec success');
        }
        $this->em->remove($property);
        $this->em->flush();
        $this->addFlash('success','Bien supprimé avec success');

        return $this->redirectToRoute('admin.property.index');

    }

}