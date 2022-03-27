<?php

define('DEMO_JWT', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.7O7cu4UGyIvZ_RnrEdKm4BMZUZcb5uNOyGc1HqALNmQ');

$postData = http_build_query([
    'topic' => 'test_topic',
    'data' => json_encode(['key' => 'updated value']),
]);

echo file_get_contents('http://127.0.0.1:9090/.well-known/mercure', false, stream_context_create(['http' => [
    'method'  => 'POST',
    'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Bearer ".DEMO_JWT,
    'content' => $postData,
]]));