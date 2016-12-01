<?php

namespace Drupal\d8_training\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class EventManager implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		$events[KernelEvents::RESPONSE][] = array('addHeader');

		return $events;
	}

	public static function addHeader(FilterResponseEvent $event) {
		$response = $event->getResponse();
		$response->headers->add(['Access-Control-Allow-Origin' => '*']);
	}
}