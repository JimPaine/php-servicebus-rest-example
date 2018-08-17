<?php
    class ServiceBusMessage
    {
        public $body;

        public $id;

        public $lockToken;

        public $uri;

        public $authHeader;

        public function __construct($body, $id, $lockToken, $uri, $authHeader)
        {
            $this->body = $body;
            $this->id = $id;
            $this->lockToken = $lockToken;
            $this->uri = $uri;
            $this->authHeader = $authHeader;
        }        
    }
?>