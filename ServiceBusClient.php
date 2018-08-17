<?php

    require_once 'vendor/autoload.php';
    require_once 'ServiceBusMessage.php';

    class ServiceBusClient
    {
        private $httpClient;

        public function __construct()
        {
            $this->httpClient = new \GuzzleHttp\Client();
        }

        public function peek($subscriptionUri, $header)
        {
            try
            {
                $response = $this->httpClient->request('POST', $subscriptionUri.'/messages/head?timeout=60&api-version=2015-01', $header);
                $body = $response->getBody();

                $response_headers = json_decode($response->getHeader('BrokerProperties')[0]);
                $messageId = $response_headers->MessageId;
                $lockToken = $response_headers->LockToken;

                return new ServiceBusMessage($body, $messageId, $lockToken, $subscriptionUri, $header);
            }
            catch(Exception $exception)
            {
                throw $exception;
            }            
        }

        public function delete($message)
        {
            try
            {
                $response = $this->httpClient->request('DELETE', $message->uri.'/messages/'.$message->id.'/'.$message->lockToken, $message->authHeader);
                return $response->getBody();
            }
            catch(Exception $exception)
            {
                throw $exception;
            }            
        }
    }
?>