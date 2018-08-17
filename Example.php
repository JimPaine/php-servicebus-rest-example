<?php

    require_once 'ServiceBusClient.php';
    require_once 'SasTokenHelper.php';

    try
    {
        $serviceBusClient = new ServiceBusClient();
        $sasTokenHelper = new SasTokenHelper();

        $serviceBusRootUri = "";
        $subscriptionName = "";
        $expiry = new DateTime('2019-01-01');
        $keyName = "";
        $privateKey = "";

        $header = $sasTokenHelper->generateSasAuthorizationHeader($serviceBusRootUri, $expiry, $keyName, $privateKey);

        for ($i=1; $i<=5; $i++) {
            $message = $serviceBusClient->peek($serviceBusRootUri.'subscriptions/'.$subscriptionName, $header);   
            echo "Body: ".$message->body."<br />";
            $serviceBusClient->delete($message);
        }
    }
    catch(Exception $e){
        echo "Error: ".$e->getMessage();
    }
?>
