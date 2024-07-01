<?php

namespace App\Service;

use Symfony\Component\Routing\RouterInterface;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RegisteredUserLoginService
{
    private $router;
    private $logger;

    public function __construct(
        RouterInterface $router,
        LoggerInterface $logger
    ) {
        $this->router = $router;
        $this->logger = $logger;
    }

    public function getToken(string $email, string $password): ?string
    {
        $baseUrl = $_ENV['API_BASE_URL'];
        $url = $baseUrl . $this->router->generate('api_login_check');

        $this->logger->info('Requesting token', ['url' => $url, 'email' => $email]);

        $client = new Client([
            'timeout' => 30,
            'verify' => false // Disable SSL verification for local development
        ]);

        try {
            $response = $client->post($url, [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $this->logger->info('Response received', ['status_code' => $statusCode]);

            if ($statusCode === 200) {
                $content = json_decode($response->getBody(), true);
                return $content['token'] ?? null;
            } else {
                $this->logger->error('Failed to get token', [
                    'status_code' => $statusCode,
                    'response' => $response->getBody()->getContents()
                ]);
            }
        } catch (GuzzleException $e) {
            $this->logger->error('Guzzle exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return null;
    }
}
