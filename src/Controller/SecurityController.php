<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
   public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder){
       $user = new User();
       $user->setRole('ROLE_USER');
       $form = $this->createForm(RegistrationType::class, $user);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()){
           $data = $form->getData();
           $username = $data->getUsername();
           $hash = $encoder->encodePassword($user,$user->getPassword());
           $user->setPassword($hash);
           $manager->persist($user);
           $manager->flush();
           $this->addFlash('success','votre compte a été crée avec success'.' '.$username);
           return $this->redirectToRoute('security_login');
       }

       return $this->render('security/registration.html.twig',[
           'form' => $form->createView()
       ]);
   }
   /**
    * @Route("/connexion",name="security_login")
    */
   public function login(AuthenticationUtils $authenticationUtils){
       $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig',[
            'error' =>$error
        ]);
   }
   /**
    * @Route("/deconnexion", name="security_logout")
    */
   public function logout(){
        return $this->redirectToRoute('product');
   }
}
