<?php     
function fetchFromApi(string $url, ?string $apiKey = "ziqh172nHHxEEDkWmbqMykllPb4q56M7JFr9QGok70oDBoJUNjvtQC3If8gx0lQw"): ?array
{
    try {
   
        $ch = curl_init();
        if ($ch === false) {
            throw new Exception("Failed to initialize cURL");
        }

        $headers = [];
        if ($apiKey) {
            $headers[] = "X-API-KEY: $apiKey";
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            throw new Exception("HTTP Error: $httpCode when fetching $url");
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Decode Error: " . json_last_error_msg());
        }

        return $decoded;
    } catch (Exception $e) {
        // Log and optionally display errors
        error_log($e->getMessage());
        echo $e->getMessage();
        return null;
    }
}
