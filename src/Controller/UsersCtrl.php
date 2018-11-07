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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use App\Entity\User;

class UsersCtrl extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array(), array('username' => 'ASC'));

        return $this->render('users/index.html.twig', array('users' => $users));
    }

    /**
     * @Route("/users/show/{id}", name="user_show")
     */
    public function show($id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('users/show.html.twig', array('user' => $user));
    } 

    /**
     * @Route("/users/add", name="user_add")
     * Method({"GET", "POST"})
     */
    public function add(Request $request) {
        $user = new User();
        
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array(
                'label' => 'Login',
                'attr' => array('class' => 'form-control')
                ))
            ->add('email', TextType::class, array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array(
                    'label' => 'Hasło',
                    'attr' => array('class' => 'form-control')),
                'second_options' => array(
                    'label' => 'Powtórz hasło',
                    'attr' => array('class' => 'form-control')),
            ))
            ->add('register', SubmitType::class, array(
                'label' => 'Dodaj',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword(
                $this->encoder->encodePassword($user, $user->getPlainPassword())
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }
            
        return $this->render('/users/add.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/users/delete/{id}", name="user_delete")
     */
    public function delete(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
