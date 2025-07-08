<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Webhook_lib
{
    protected $ci;
    protected $apiKey = 'sk_test_FwzdJLmJEVdx6TAX1B7TtteT'; // PayMongo secret key

    public function __construct()
    {
        // Load CI super object
        $this->ci = &get_instance();
    }

    /**
     * Logs messages to a file in application/logs with the function name and date.
     * 
     * @param string $function_name The name of the function calling the logger
     * @param string $message The message to log
     */
    private function log_message($function_name, $message)
    {
        // Log file directory and name
        $log_dir = APPPATH . 'logs/';
        $log_file = $log_dir . $function_name . '_' . date('Y-m-d') . '.txt';

        // Create the logs directory if it doesn't exist
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true); // Create directory with write permissions
        }

        // Construct log message with timestamp
        $log_message = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;

        // Append the message to the log file
        file_put_contents($log_file, $log_message, FILE_APPEND);

        // Optionally, you can also log this in the CodeIgniter logs using:
        // log_message('info', $message);
    }

    /**
     * Handles the webhook callback from PayMongo
     */
    public function webhook()
    {
        $this->log_message(__FUNCTION__, "Webhook called");

        // Get the raw POST data from PayMongo
        $input = @file_get_contents("php://input");

        // Decode the JSON payload
        $event = json_decode($input, true);

        // Log the received event
        $this->log_message(__FUNCTION__, "Received event: " . json_encode($event));

        // Validate the webhook signature
        $signature = $_SERVER['HTTP_PAYMONGO_SIGNATURE'] ?? null;

        if ($signature && $this->verify_signature($input, $signature)) {
            // Process event based on its type
            $eventType = $event['data']['attributes']['type'] ?? null;
            $this->log_message(__FUNCTION__, "Event type: $eventType");

            if ($eventType === 'payment.paid') {
                $this->confirm_booking($event['data']['id']); // Payment success
                $this->log_message(__FUNCTION__, "Payment confirmed with ID: " . $event['data']['id']);
            } elseif ($eventType === 'payment.failed') {
                $this->decline_booking($event['data']['id']); // Payment failure
                $this->log_message(__FUNCTION__, "Payment failed with ID: " . $event['data']['id']);
            }
        } else {
            // Invalid signature
            http_response_code(400);
            $this->log_message(__FUNCTION__, "Invalid signature");
            echo "Invalid signature";
        }

        // Acknowledge the webhook reception
        http_response_code(200);
        echo "Webhook received and processed";
    }

    /**
     * Verifies the signature sent from PayMongo
     * 
     * @param string $payload
     * @param string $signature
     * @return bool
     */
    private function verify_signature($payload, $signature)
    {
        $secret = $this->apiKey; // Secret key used for hashing
        $computed_signature = hash_hmac('sha256', $payload, $secret);
        $is_valid = hash_equals($signature, $computed_signature);

        // Log signature verification result
        $this->log_message(__FUNCTION__, "Signature verification: " . ($is_valid ? "valid" : "invalid"));

        return $is_valid;
    }

    /**
     * Creates a webhook for a specific booking
     * 
     * @param int $booking_id
     * @return string|bool Webhook ID or false on failure
     */
    public function create_webhook()
    {
        // $this->log_message(__FUNCTION__, "Creating webhook for booking ID: $booking_id");

        $data = [
            'data' => [
                'attributes' => [
                    'events' => ['payment.paid', 'payment.failed'], // Events to listen for
                    'url' => base_url("booking_info/payment_success"), // Webhook URL
                    'secret' => 'your-webhook-secret', // Optional secret for validation
                ],
            ],
        ];

        $response = $this->send_request('POST', 'https://api.paymongo.com/v1/webhooks', $data);

        if ($response && isset($response['data']['id'])) {
            $webhookId = $response['data']['id'];
            $this->log_message(__FUNCTION__, "Webhook created successfully with ID: $webhookId");
            return $webhookId;
        } else {
            $this->log_message(__FUNCTION__, "Error creating webhook: " . json_encode($response));
            return false;
        }
    }

    /**
     * Deletes a webhook by ID
     * 
     * @param string $webhook_id
     */
    public function delete_webhook($webhook_id)
    {
        $this->log_message(__FUNCTION__, "Deleting webhook with ID: $webhook_id");

        $url = "https://api.paymongo.com/v1/webhooks/$webhook_id";
        $response = $this->send_request('DELETE', $url);

        if ($response) {
            $this->log_message(__FUNCTION__, "Webhook deleted successfully.");
        } else {
            $this->log_message(__FUNCTION__, "Error deleting webhook: " . json_encode($response));
        }
    }

    /**
     * Retrieves all configured webhooks
     */
    public function get_all_webhooks()
    {
        $this->log_message(__FUNCTION__, "Fetching all webhooks");

        $response = $this->send_request('GET', 'https://api.paymongo.com/v1/webhooks');

        if ($response && isset($response['data'])) {
            $this->log_message(__FUNCTION__, "Retrieved webhooks: " . json_encode($response['data']));
            echo "<pre>";
            print_r($response['data']); // Display all webhooks
            echo "</pre>";
        } else {
            $this->log_message(__FUNCTION__, "Error retrieving webhooks: " . json_encode($response));
        }
    }

    /**
     * Helper function to handle cURL requests
     * 
     * @param string $method HTTP method (GET, POST, DELETE)
     * @param string $url API endpoint
     * @param array|null $data Data to be sent in the request (for POST requests)
     * @return array|bool API response or false on failure
     */
    private function send_request($method, $url, $data = null)
    {
        $ch = curl_init($url);

        // Common cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode($this->apiKey . ':'),
            'Content-Type: application/json',
        ]);

        // Additional options based on request method
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        // Execute the request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            return false;
        }
    }
}
