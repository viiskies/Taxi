<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends Controller
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route("/login/", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils)
    {
        $last_username = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $last_username,
            'error' => $error
        ]);
    }

    /**
     * @Route("/register/", name="register")
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            var_dump($request);
//            exit;
            $password = $this->userPasswordEncoder->encodePassword($user, 'vitkis');
            $user ->setPassword($password);
            $user ->setRoles(['ROLE_ADMIN']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('login/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
