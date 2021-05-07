<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Form\RegistrationEtudiantFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/enseignants/inscription", name="app_registration_inscriptionEnseignant")
     */
    public function inscriptionEnseignant(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $user = new Enseignant;
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On encode le mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/inscriptionEnseignant.html.twig', [
            'formInscription' => $form->createView()
        ]);
    }

    /**
     * @Route("/etudiants/inscription", name="app_registration_inscriptionEtudiant")
     */
    public function inscriptionEtudiant(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $user = new Etudiant;
        $form = $this->createForm(RegistrationEtudiantFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On encode le mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/inscriptionEtudiant.html.twig', [
            'formInscription' => $form->createView(),
            'etudiant' => true
        ]);
    }
}