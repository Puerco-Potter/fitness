<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Route("/")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
    }

     /**
     * @Route("/logout" , name="cerrarSesion")
     */
    public function logout(Request $request){

        $this->get('session')->clear();
        $session = $this->get('session');
        $ses_vars = $session->all();
        foreach ($ses_vars as $key => $value) {
            $session->remove($key);
        }
        session_destroy();
          return $this->redirectToRoute('login');

    }
}