<?php
    class SasTokenHelper
    {
        public function generateSasAuthorizationHeader($resourceUri, $expiry, $keyName, $privateKey)
        { 
            $encodeUri = urlencode($resourceUri); 
            $timeout = $this->calculateEpoch($expiry); 
            $sasToken = $this->generateSasToken($encodeUri, $timeout, $privateKey);
 
            return array('headers' => array('Authorization'=>'SharedAccessSignature sig='.$sasToken.'&se='.$timeout.'&skn='.$keyName.'&sr='.$encodeUri));
        } 
 
        private function generateSasToken($encodeUri, $timeout, $privateKey)
        { 
            $hash = hash_hmac('sha256', $encodeUri."\n".$timeout, $privateKey, true);
            return urlencode(base64_encode($hash));
        } 
 
        private function calculateEpoch($expiry) 
        {
            return $expiry->format('U');
        }
    }
?>