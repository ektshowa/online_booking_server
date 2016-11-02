<?php
namespace AbstractModels;

abstract class AbstractRoleModel {
    abstract function getRole();
    abstract function setRole($role);
    abstract function getDescription();
    abstract function setDescription($description);
    abstract function setSortOrder($sortOrder);
    abstract function getSortOrder();
    abstract function setActive($active);
    abstract function getActive();
}
?>
