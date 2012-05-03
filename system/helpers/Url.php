<?php
/*
| ---------------------------------------------------------------
| Method: getPageContents()
| ---------------------------------------------------------------
|
| Uses either file() or CURL to get the contents of a page
|
*/
function getPageContents($url)
{
    // Properly format our url
    $url = str_replace(' ', '%20', $url);
    $results = false;
    
    // Try to fetch the page with cURL
    if( function_exists('curl_exec') ) 
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
        $results = curl_exec($curl_handle);
        
        // Check if any error occured
        if(curl_errno($curl_handle))
        {
           return false;
        }

        $results = explode("\n", trim($results));
        curl_close($curl_handle);
    }
    
    // Try file() first
    elseif( ini_get('allow_url_fopen') ) 
    {
        $results = @file($url);
    }
    
    // Return the page
    return $results;
}
// EOF