<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Instance
 *
 * @ORM\Table(name="instance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InstanceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Instance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="instance")
     */
    private $users;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    protected $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Instance
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Instance
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Instance
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    public function addUser(User $user)
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;

            $user->setInstance($this);
        }
        return $this;
    }

    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    public function getUsers()
    {
        return $this->users;
    }




    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \Datetime());
        }
        $this->setUpdatedAt(new \DateTime());
    }
}

