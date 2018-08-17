# Example Peek and Delete from Azure Service Bus using PHP

Using the native REST API to consume messages from the Service Bus Topic using PHP

## Using the example classes

Firstly there is an assumption a Service Bus has been created in Azure along with a topic and a subcription.
You will also need to take not of the shared access key name and value from the portal.

Then to utilize these examples ensure to require the classes in your file, like so.

```php
    require_once 'ServiceBusClient.php';
    require_once 'SasTokenHelper.php';
```

## Generation of the SAS token required for authentication

In Example.php you will see a method being called

```php
    $header = $sasTokenHelper->generateSasAuthorizationHeader($serviceBusRootUri, $expiry, $keyName, $privateKey);
```

The parameters for this method are as follows

| Parameter          | Example Value                                  | Comment |
| ------------------ |:----------------------------------------------:| -------:|
| $serviceBusRootUri | "https://mybus.servicebus.windows.net/mytopic" |         |
| $expiry            | new DateTime('2019-01-01')                     |         |
| $keyName           | "RootManageSharedAccessKey"                    |         |
| $privateKey        | "pMw68C073oeaIRr54KKDO+QB2CK6imQ1lYZXiwafu31=" |         |

This will generate a populated headers array, including the authorization header populated with a signed shared access signature.

## Peek a message from the topc subscription

```php
    $message = $serviceBusClient->peek($serviceBusRootUri.'subscriptions/'.$subscriptionName, $header);
```

As you can see, you will need to pass in the header and the subscription name you would like to peek from. The response will include the content of the message as well as the details needed to perform the delete later on.

```php
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
```

## Delete a message from the topic subscription

To perform the delete of the message simply call the delete method as show here

```php
    $serviceBusClient->delete($message);
```