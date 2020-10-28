<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConferenceRepository;
use Twig\Environment;
use App\Entity\Conference;
use App\Repository\CommentRepository;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    //public function index(string $name = ''): Response
    public function index(Environment $twig, ConferenceRepository $conferenceRepository)
    {
        // return $this->render('conference/index.html.twig', [
        //     'controller_name' => 'ConferenceController',
        // ]);
        /*$greet = '';
        if ($name) {
            $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        }
        return new Response(<<<EOF
            <html>
                <body>
                    $greet
                    <img src="/images/under-construction.gif" />
                </body>
            </html>
            EOF
        );*/
        return new Response($twig->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]));
    }
     /**
      * @Route("/conference/{id}", name="conference")
     */
    public function show(Environment $twig, Conference $conference,CommentRepository $commentRepository)
    {
        return new Response($twig->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $commentRepository->findBy(['conference' =>$conference], ['createdAt' => 'DESC']),
        ]));
    }
}
