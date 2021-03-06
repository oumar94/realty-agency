<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $k;
    public  function __construct()
    {
        $this->k=0;
    }

    /**
     * @Route("/login",name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @param int $k
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $last_username=$authenticationUtils->getLastUsername();
        $error=$authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig',[
                    'last_username'=>$last_username,
                    'error'=>$error
                ]) ;
    }
}