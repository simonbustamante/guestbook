<?php

namespace App\MessageHandler;

use App\Message\CommentMessage;
use App\ImageOptimizer;
use App\Repository\CommentRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CommentMessageHandler implements MessageHandlerInterface
{
    private $spamChecker;
    private $entityManager;
    private $commentRepository;
    private $bus;
    private $workflow;
    private $logger;
    private $mailer;
    private $imageOptimizer;
    private $photoDir;
    private $adminEmail;

    public function __construct(
        EntityManagerInterface $entityManager,
        SpamChecker $spamChecker,
        CommentRepository $commentRepository,
        MessageBusInterface $bus,
        WorkflowInterface $commentStateMachine,
        MailerInterface $mailer,
        string $adminEmail,
        ImageOptimizer $imageOptimizer,
        string $photoDir,
        LoggerInterface $logger = null
    ) {
        $this->entityManager = $entityManager;
        $this->spamChecker = $spamChecker;
        $this->commentRepository = $commentRepository;
        $this->bus = $bus;
        $this->workflow = $commentStateMachine;
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
        $this->imageOptimizer = $imageOptimizer;
        $this->photoDir = $photoDir;
    }
    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRepository->find($message->getId());
        if (!$comment) {
            return;
        }
        /*if (2 === $this->spamChecker->getSpamScore($comment,$message->getContext()
        )) {
            $comment->setState('spam');
        } else {
            $comment->setState('published');
        }
        $this->entityManager->flush();*/
        if ($this->workflow->can($comment, 'accept')) {
            $score = $this->spamChecker->getSpamScore($comment, $message->getContext());
            $transition = 'accept';

            if (2 === $score) {
                $transition = 'reject_spam';
            } elseif (1 === $score) {
                $transition = 'might_be_spam';
            }
            $this->workflow->apply($comment, $transition);
            $this->entityManager->flush();
            $this->bus->dispatch($message);
        } elseif ($this->workflow->can($comment, 'publish') || $this->workflow->can($comment, 'publish_ham')) {
            /*$this->workflow->apply($comment, $this->workflow->can($comment, 'publish') ? 'publish' : 'publish_ham');
            $this->entityManager->flush();*/
            $this->mailer->send((new NotificationEmail())
                ->subject('New comment posted')
                ->htmlTemplate('emails/comment_notification.html.twig')
                ->from($this->adminEmail)
                ->to($this->adminEmail)
                ->context(['comment' => $comment]));
        } elseif ($this->workflow->can($comment, 'optimize')) {
            if ($comment->getPhotoFilename()) {
                $this->imageOptimizer->resize($this->photoDir . '/' . $comment->getPhotoFilename());
            }
            $this->workflow->apply($comment, 'optimize');
            $this->entityManager->flush();
        } elseif ($this->logger) {
            $this->logger->debug('Dropping comment message', ['comment' =>
            $comment->getId(), 'state' => $comment->getState()]);
        }
    }
}
