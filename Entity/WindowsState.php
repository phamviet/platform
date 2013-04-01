<?php

namespace Oro\Bundle\WindowsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Window state container Entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="windows_state",
 *      indexes={@ORM\Index(name="windows_user_idx", columns={"user_id"})})
 */
class WindowsState
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Oro\Bundle\UserBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $user;

    /**
     * @var string $data
     *
     * @ORM\Column(name="data", type="text", nullable=false)
     */
    protected $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

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
     * Set data
     *
     * @param mixed $data
     * @return \Oro\Bundle\WindowsBundle\Entity\WindowsState
     */
    public function setData($data)
    {
        $this->data = json_encode($data);

        return $this;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    public function getData()
    {
        return json_decode($this->data, true);
    }

    /**
     * Get JSON data
     *
     * @return string
     */
    public function getJsonData()
    {
        return $this->data;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return \Oro\Bundle\WindowsBundle\Entity\WindowsState
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
     * @return \Oro\Bundle\WindowsBundle\Entity\WindowsState
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

    /**
     * Set user
     *
     * @param \Oro\Bundle\UserBundle\Entity\User $user
     * @return \Oro\Bundle\WindowsBundle\Entity\WindowsState
     */
    public function setUser(\Oro\Bundle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Oro\Bundle\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Pre persist event handler
     *
     * @ORM\PrePersist
     */
    public function doPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
    }

    /**
     * Pre update event handler
     *
     * @ORM\PreUpdate
     */
    public function doPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
