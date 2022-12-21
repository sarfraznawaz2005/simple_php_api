# Simple PHP API

This script allows other sites to post data to us and then we can use that data to save in database or any other purpose. The code of API itself is in `index.php` file.

We give them fixed secret key and they must pass that secret via bearer token to be able to call our API.

This example will actually log posted data into `log.txt` file.

### Usage

```php
// Set the request URL and HTTP method
$url = 'https://domain.com/api/';

// Set the request body (if applicable)
$data = array('field1' => 'value1', 'field2' => 'value2');

$options = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer 0cd5cb10880d70d7c45eb53c07a2757bf38e933b456fc1594e3ca9a3dd40d9e5'
    ),
);

// Send the request
$curl = curl_init();
curl_setopt_array($curl, $options);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// Handle the response
if ($status !== 200) {
    // Request failed
    echo "Request failed with status code $status\n";
} else {
    // Request succeeded
    $response = json_decode($result);
    print_r($response);
}

```

Note that in above example, we have used PHP to call our API but other sites can call our API in any language, they just need to send POST request to us and also add `Authorization` header in their request with bearer secret that we will provide them.

---

**NOTE:** If `Authorization` is not being passed correctly to our API, we can use put `.htaccess` file from this code in same folder where this API will reside.