<?php
namespace App\EventListener;

//use App\Entity\ContainingTagsInterface;
use App\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TagsUpdate    
{
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function preFlush(/* ContainingTagsInterface */ $entity, PreFlushEventArgs $event): void
    {
        $this->updateTags($entity, $event->getEntityManager());
    }

    private function updateTags($entity, $entityManager){

        /*
        if(!method_exists($entity,'getTags')){
            return;
        }
        $tags = explode(',', $entity->getTags());
        $this->removeAllTags($entity, $tags);
        */
        /*
        // Remove existing tags inside entity from $tags array
        $excessiveTags = $this->getExcessiveTags($entity, $tags);

        $this->assignNewTagsToEntity($entity, $excessiveTags, $em);   
        */     
    }
/*
    private function removeAllTags($entity, $tags){

        $repository = $entityManager->getRepository(Page::class); 
        $repository
        /*
        $pageId = $entity->getId();
        foreach($tags as $tag){
            $page = $tag->getPage();
            echo '<br><br><br>';
            var_dump($page);
        }
        
        var_dump($tags);
        die();
    }
    */

}