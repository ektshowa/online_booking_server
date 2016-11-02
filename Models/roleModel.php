<?php
namespace Models;

require_once ABSTRACT_MODELS_FOLDER . "abstractRoleModel.php";

use Doctrine\Common\Collections\ArrayCollection;
use AbstractModels\AbstractRoleModel;

/**
 * @Entity @Table(name="roles")
 */
 class RoleModel extends AbstractRoleModel {
     
    /**
     * @var int
     * @Id @Column(type="integer") @GeneratedValue
     */ 
    protected $id;
    
    /**
     * @Column(type="string")
     * @var string
     */
    protected $role;
     
    /**
     * @Column(type="integer")
     * @var int
     */
    protected $sortOrder;
      
    /**
     * @Column(type="string")
     * @var string
     */
    protected $description;
       
    /**
     * @Column(type="string")
     * @var string
     */
    protected $active;
    
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $createdDate;
    
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $updatedDate;
    
    /**
     * @OneToMany(targetEntity="SubscriberModel", mappedBy="role")
     * @var subscriberModel[]
     */
    protected $assignedSubscribers = null;
     
    public function __construct() {
         $this->assignedSubscribers = new ArrayCollection();
    }
    
    public function getId() {
            if ($this->id > 0) {
                $result['success'] = TRUE;
                $result['data'] = $this->id;        
            }
            else {
                $result['success'] = FALSE;
                $result['message'] = "Role Model - getId(): Id not set";
            }
            return $result;
    }
    
    public function setRole($role) {
        if (!empty($role)) {
            $this->role = $role;
            return TRUE;    
        }
        else {
            $this->role = null;
            trigger_error("Role Model - setRole(): Parameter not set");
            return FALSE;
        }
        
    }
    
    public function getRole() {
        if (!empty($this->role)) {
            $result['data'] = $this->role;
            $result['success'] = TRUE;
        }
        else {
            $result['message'] = "Role Model - getRole(): Role not set";
            $result['success'] = FALSE;
        }
        return $result;
    }
    
    public function getSortOrder() {
        if (!empty($this->sortOrder)) {
            $result['data'] = $this->sortOrder;
            $result['success'] = TRUE;
        }
        else {
            $result['message'] = "Role Model - getSortOrder(): SortOrder nor set";
            $result['success'] = FALSE;
        }
        return $result;
    }
    
    public function setSortOrder($sortOrder) {
        if (!empty($sortOrder)) {
            $this->sortOrder = $sortOrder;
            return TRUE;    
        }
        else {
            $this->sortOrder = null;
            trigger_error("Role Model - setSortOrder(): Parameter not set");
            return FALSE;
        }
        
    }   
     
    public function getActive() {
        if (!empty($this->active)) {
            $result['data'] = $this->active;
            $result['success'] = TRUE;
        }
        else {
            $result['message'] = "Role Model - getActive(): SortOrder nor set";
            $result['success'] = FALSE;
        }
        return $result;
    }
    
    public function setActive($active) {
        if (!empty($active)) {
            $this->active = $active;
            return TRUE;    
        }
        else {
            $this->active = null;
            trigger_error("Role Model - setActive(): Parameter not set");
            return FALSE;
        }
        
    }
    
    public function getDescription() {
        if (!empty($this->description)) {
            $result['data'] = $this->description;
            $result['success'] = TRUE;
        }
        else {
            $result['message'] = "Role Model - getDescription(): Description nor set";
            $result['success'] = FALSE;
        }
        return $result;
    }
    
    public function setDescription($description) {
        if (!empty($description)) {
            $this->description = $description;
            return TRUE;    
        }
        else {
            $this->description = null;
            trigger_error("Role Model - setDescription(): Parameter not set");
            return FALSE;
        }
        
    }
        
    public function setCreatedDate(DateTime $createDate) {
        if (!empty($createDate)) {
            $this->createdDate = $createDate;
            return TRUE;
        }
        else {
            $this->createdDate = null;
            trigger_error("Role Model - setCreatedDate(): Parameter not set");
            return FALSE;
        }
    }
    
    public function getCreatedDate() {
        if (!empty($this->createdDate)) {
            $result['success'] = TRUE;
            $result['data'] = $this->createdDate;
        }
        else {
            $result['message'] = "Role Model - getCreatedDate(): CreatedDate not set";
            $result['success'] = FALSE;
        }
        return $result;
    }
    
    public function setUpdatedDate(DateTime $updatedDate) {
        if (!empty($updatedDate)) {
            $this->updatedDate = $updatedDate;
            return TRUE;
        }
        else {
            $this->updatedDate = null;
            trigger_error("Role Model - setUpdatedDate(): Parameter not set");
            return FALSE;
        }
    }
    
    public function getUpdatedDate() {
        if (!empty($this->updatedDate)) {
            $result['success'] = TRUE;
            $result['data'] = $this->updatedDate;
        }
        else {
            $result['message'] = "Role Model - getUpdatedDate(): UpdatedDate not set";
            $result['success'] = FALSE;
        }
        return $result;
    }    
    
    public function assignedToSubscriber($subscriber) {
        $this->assignedSubscribers[] = $subscriber;
    }    
        
 }
