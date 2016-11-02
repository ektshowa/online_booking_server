<?php
namespace AbstractControllers;

abstract class AbstractSubscriberController {
	abstract function createSubscriber(array $params);
	abstract function readSubscriber(array $params);
	abstract function updateSubscriber(array $params);
	abstract function deleteSubscriber(array $params);
}
