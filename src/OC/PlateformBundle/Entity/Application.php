<?php
// src/OC/PlatformBundle/Entity/Application.php

namespace OC\PlateformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OC\PlateformBundle\Entity\ApplicationRepository")
 */
class Application
{


    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OC\PlateformBundle\Entity\Advert")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    public function getAdvert()
    {
        return $this->advert;
    }


    /**
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }


    /**
     * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\ApplicationRepository")
     * @ORM\HasLifecycleCallbacks()
     */

    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $this->getAdvert()->increaseApplication();
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $this->getAdvert()->decreaseApplication();
    }



}
