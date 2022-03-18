<?php

namespace App\EntityListener;

use App\Entity\Conference;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * Class ConferenceEntityListener
 *
 * @package App\EntityListener
 */
class ConferenceEntityListener
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     *
     * @param Conference         $conference
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Conference $conference, LifecycleEventArgs $event)
    {
        $conference->computeSlug($this->slugger);
    }

    /**
     *
     * @param Conference         $conference
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(Conference $conference, LifecycleEventArgs $event)
    {
        $conference->computeSlug($this->slugger);
    }
}
