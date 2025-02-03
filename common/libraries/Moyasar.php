<?php
namespace common\libraries;

use Yii;

class Moyasar
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = Yii::$app->params['moyasarApiKey']; // Set your API key in params
    }

    public function generatePaymentLink($invoiceId, $amount)
    {
        $url = "https://api.moyasar.com/v1/invoices";
        $apiKey = Yii::$app->params['moyasarSecretKey']; // Add this to params-local.php as 'moyasarSecretKey'

        // Prepare the data for the POST request
        $data = [
            'amount' => $amount * 100, // Convert to smallest currency unit (halalas)
            'currency' => 'SAR',
            'description' => "Payment for invoice ID $invoiceId",
            'callback_url' => CustomWidgets::apiUrl() . '/payment/verify-payment', //Yii::$app->urlManager->createAbsoluteUrl(['payment/verify']),
        ];

        // Initialize cURL session
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, true);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Check for errors in the cURL request
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the response JSON to access the generated payment URL
        $responseData = json_decode($response, true);
        if (isset($responseData['url'])) {
            return $responseData; // Payment Details from Moyasar
        } else {
            throw new \Exception('Failed to generate payment link: ' . $responseData['message'] ?? 'Unknown error');
        }
    }

    /**
     * Verify payment
     *
     * @param string $paymentId Payment ID from Moyasar response
     * @return array Verification status and details
     */
    public function verifyPayment($paymentId)
    {
        $url = "https://api.moyasar.com/v1/payments/$paymentId";
        $headers = [
            "Authorization: Basic " . base64_encode($this->apiKey . ":")
        ];

        // Initialize cURL request for payment verification
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
