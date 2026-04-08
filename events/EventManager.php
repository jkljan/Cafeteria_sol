<?php
require_once "Subscriber.php";

class EventManager {

    private $subscribers = [];

    // Suscribir observadores
    public function subscribe(Subscriber $subscriber) {
        $this->subscribers[] = $subscriber;
    }

    // Notificar eventos
    public function notify($data) {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($data);
        }
    }
}