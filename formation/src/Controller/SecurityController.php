<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/create_admin", name="create_admin")
     */
    public function createAdmin(UserPasswordEncoderInterface $passwordEncoder)
    {

        $admin = new User();
        $admin->setEmail('admin@dawan.fr')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword(
                  $passwordEncoder->encodePassword($admin, 'toto123')
              )
              ;

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return new Response("Admin Créé !");

    }

    /**
     * @Route("/my_infos", methods={"GET"}, name="mesInfos")
     * @IsGranted("ROLE_USER")
     */
    public function mesInfos() 
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        return $this->render('security/myinfos.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/my_infos", methods={"POST"}, name="mesInfosPost")
     * @IsGranted("ROLE_USER")
     */
    public function mesInfosPost(Request $request, UserPasswordEncoderInterface $passwordEncoder) 
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isValid()) {

            if($form->get('clearPassword')->getData() != null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('clearPassword')->getData()
                    )
                );
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('listPlayer');
            
        }

        return $this->render('security/myinfos.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
