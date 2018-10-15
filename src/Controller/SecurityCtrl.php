<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use App\Entity\User;

class SecurityCtrl extends AbstractController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/register", name="register")
     */
    public function register() {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword(
            $this->encoder->encodePassword($user, 'admin')
        );
        $user->setEmail('my-email@suck.it');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('/');
    }

    /**
     * @Route("/login", name="login")
     * Method({"GET", "POST"})
     */
    public function login(Request $request, AuthenticationUtils $utils) {
        $user = new User();
            
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array(
                'attr' => array('class' => 'form-control')
                ))
            ->add('password', PasswordType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('login', SubmitType::class, array(
                'label' => 'Zaloguj',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            return $this->redirectToRoute('/');
        }

        $error = $utils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {

    }
}
