<?php

// first run in cmd => composer require google/apiclient:^2.0

require __DIR__ . '/vendor/autoload.php';

//Reading data from spreadsheet.

$client = new \Google_Client();

$client->setApplicationName('Google Sheets and PHP');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);

$spreadsheetId = "1cTEu7fqeSr6cDxtxi9xOBxYOMhXgjfkUsouG-vUB5jc"; //It is present in your URL

$get_range = "sheet1!A1:C3";
$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
$values = $response->getValues();

print_r($values);

$val = array(
    f
);

$updateBody = new \Google_Service_Sheets_ValueRange([
            'range' => $get_range,
            'majorDimension' => 'ROWS',
            'values' => ['values' => $val],
        ]);
        $service->spreadsheets_values->update(
            $spreadsheetId,
            $get_range,
            $updateBody,
            ['valueInputOption' => 'USER_ENTERED']
        );

$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);
$values = $response->getValues();

print_R($values);


?>