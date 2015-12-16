<?php

namespace Ace\CommonBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ace\CommonBundle\Entity\Repository\BlogRepository")
 * @Vich\Uploadable
 */
class Blog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="intro", type="text")
     */
    private $intro;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="blogs")
     */
    private $events;

    /**
     * @var File
     *
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="blog_image", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @ORM\Column(name="image_name", type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @var User
     *
     * @ORM\ManyToOne(
     *     targetEntity="User"
     * )
     * @ORM\JoinColumn(
     *     name="created_by",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(
     *     targetEntity="User"
     * )
     * @ORM\JoinColumn(
     *     name="updated_by",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $updatedBy;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->events = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Blog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set intro
     *
     * @param string $intro
     *
     * @return Blog
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Blog
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection $events
     *
     * @return Event
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return $this
     */
    public function addEvent(Event $event)
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addBlog($this);
        }

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return $this
     */
    public function removeEvent(Event $event)
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeBlog($this);
        }

        return $this;
    }

    public function removeNotExistedEvents(ArrayCollection $originalEvents)
    {
        /** @var Event $event */
        foreach ($originalEvents as $event) {
            if (!$this->getEvents()->contains($event)) {
                $event->removeBlog($this);
            }
        }
    }

    public function addNotExistedEvents()
    {
        /** @var Event $event */
        foreach ($this->getEvents() as $event) {
            if (!$event->getBlogs()->contains($this)) {
                $event->addBlog($this);
            }
        }
    }


    /**
     * @param File|UploadedFile $image
     *
     * @return Event
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Event
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set cratedAt
     *
     * @param \DateTime $createdAt
     *
     * @return Blog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get cratedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     *
     * @return Blog
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param User $updatedBy
     *
     * @return Blog
     */
    public function setUpdatedBy(User $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Blog
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString()
    {
        return '('.$this->getId().') '.$this->getName();
    }
}

