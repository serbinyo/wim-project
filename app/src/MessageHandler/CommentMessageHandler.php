<?php
/**
 * Created by PhpStorm
 * User: serbin
 * Date: 10.03.2022
 * Time: 16:00
 */


namespace App\MessageHandler;


use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CommentMessageHandler
 *
 * @package App\MessageHandler
 */
class CommentMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CommentRepository $commentRepository
    ) {
        $this->entityManager = $entityManager;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param CommentMessage $message
     */
    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRepository->find($message->getId());
        if (!$comment) {
            return;
        }
        if (strpos($comment->getText(), 'купи') === false) {
            $comment->setState('published');
        } else {
            $comment->setState('spam');
        }
        $this->entityManager->flush();
    }
}