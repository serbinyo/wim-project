<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ConferenceController
 *
 * @package App\Controller
 */
class ConferenceController extends AbstractController
{
    private Environment $twig;
    private EntityManagerInterface $entityManager;

    /**
     * ConferenceController constructor.
     */
    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/", name="homepage")
     *
     *
     * @param ConferenceRepository $conferenceRepository
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return new Response(
            $this->twig->render(
                'conference/index.html.twig',
                ['conferences' => $conferenceRepository->findAll()]
            )
        );
    }


    /**
     * @Route("/conference/{slug}", name="conference")
     *
     *
     * @param Request           $request
     * @param Conference        $conference
     * @param CommentRepository $commentRepository
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(
        Request $request,
        Conference $conference,
        CommentRepository $commentRepository
    ): Response {
        //Постраничная навигация
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        //Создание формы
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        //Обработка формы
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setConference($conference);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('conference', ['slug' => $conference->getSlug()]);
        }

        //Ответ пользовательского представления
        return new Response(
            $this->twig->render(
                'conference/show.html.twig',
                [
                    'conference'   => $conference,
                    'comments'     => $paginator,
                    'previous'     => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                    'next'         => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                    'comment_form' => $form->createView()
                ]
            )
        );
    }
}
