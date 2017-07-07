<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var \string
     *
     * @ORM\Column(name="date", type="string", length=255)
     * @Assert\DateTime()
     * @Assert\NotBlank()
     * 
     */
    private $date;

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
     * Set content
     *
     * @param string $content
     * @return Comment
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
     * Set date
     *
     * @param string $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     *  @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="comments")
     *  @ORM\JoinColumn(name="taskId", referencedColumnName="id")
     */
    private $tasks;

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set tasks
     *
     * @param \AppBundle\Entity\Task $tasks
     * @return Comment
     */
    public function setTasks(\AppBundle\Entity\Task $tasks = null)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * Get tasks
     *
     * @return \AppBundle\Entity\Task 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function isOwner(User $user)
    {
        return $this->user->getId() == $user->getId();
    }

}
