<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="friend_list",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_id", referencedColumnName="id")}
     *      )
     */
    private $friends;

    /**
     * @ORM\ManyToOne(targetEntity="Instance", inversedBy="users")
     * @ORM\JoinColumn(name="instance_id", referencedColumnName="id")
     */
    private $instance;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    protected $score;

    /**
     * @var integer
     *
     * @ORM\Column(name="high_score", type="integer")
     */
    protected $highScore;

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


    public function __construct() {
        parent::__construct();
        $this->friends = new ArrayCollection();
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
     * Set instance
     *
     * @param Instance $instance
     * @return User
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * Get instance
     *
     * @return Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return User
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set highScore
     *
     * @param integer $highScore
     *
     * @return User
     */
    public function setHighScore($highScore)
    {
        $this->highScore = $highScore;

        return $this;
    }

    /**
     * Get highScore
     *
     * @return integer
     */
    public function getHighScore()
    {
        return $this->highScore;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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


    public function addFriend(User $friend)
    {
        if (!$this->friends->contains($friend))
            $this->friends[] = $friend;

        return $this;
    }

    public function removeFriend(User $friend)
    {
        $this->friends->removeElement($friend);
    }

    public function getFriends()
    {
        return $this->friends;
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
