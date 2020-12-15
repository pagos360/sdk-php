<?php

namespace Pagos360;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Pagos360\Exceptions\RestClient\BadRequestException;
use Pagos360\Exceptions\RestClient\ClientError;
use Pagos360\Exceptions\RestClient\ForbiddenException;
use Pagos360\Exceptions\RestClient\UnauthorizedException;
use Pagos360\Exceptions\RestClient\UnexpectedStatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class RestClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const JSON_DECODE_DEPTH = 512; // Default value from PHP

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param GuzzleClient $guzzleClient
     * @param string       $apiKey
     */
    public function __construct(GuzzleClient $guzzleClient, string $apiKey)
    {
        $this->guzzleClient = $guzzleClient;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $url
     * @param array  $queryParams
     * @return array
     */
    public function get(string $url, array $queryParams = []): array
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->debug("GET: $url", ['queryParams' => $queryParams]);
        }

        $response = $this->guzzleClient->get(
            $url,
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                RequestOptions::QUERY => $queryParams,
            ]
        );
        $this->assertStatusCode($response, 200);
        return $this->parseBody($response);
    }

    /**
     * @param string $url
     * @param array  $body
     * @param array  $headers
     * @return array
     * @throws ClientError
     */
    public function post(string $url, array $body, array $headers = []): array
    {
        $requestBody = json_encode($body);
        $requestHeaders = [
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];

        if (!empty($headers)) {
            $requestHeaders = array_merge($requestHeaders, $headers);
        }

        $response = $this->guzzleClient->post(
            $url,
            [
                RequestOptions::HEADERS => $requestHeaders,
                RequestOptions::BODY => $requestBody,
            ]
        );
        try {
            $this->assertStatusCode($response, 201);
        } catch (ClientError $exception) {
            $exception->appendData([
                'requestBody' => $requestBody,
            ]);

            throw $exception;
        }
        return $this->parseBody($response);
    }

    /**
     * @param string $url
     * @param array  $body
     * @return array
     * @throws ClientError
     */
    public function put(string $url, array $body): array
    {
        $requestBody = json_encode($body);
        $response = $this->guzzleClient->put(
            $url,
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                RequestOptions::BODY => $requestBody,
            ]
        );
        try {
            $this->assertStatusCode($response, 200);
        } catch (ClientError $exception) {
            $exception->appendData([
                'requestBody' => $requestBody,
            ]);

            throw $exception;
        }
        return $this->parseBody($response);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function parseBody(ResponseInterface $response): array
    {
        return json_decode(
            (string) $response->getBody(),
            true,
            self::JSON_DECODE_DEPTH,
            \JSON_BIGINT_AS_STRING
        );
    }

    /**
     * @param ResponseInterface $response
     * @param int               $expectedStatusCode
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws ForbiddenException
     * @throws UnexpectedStatusCode
     */
    private function assertStatusCode(
        ResponseInterface $response,
        int $expectedStatusCode
    ): void {
        $actualStatusCode = $response->getStatusCode();
        if ($actualStatusCode !== $expectedStatusCode) {
            $body = json_decode((string)$response->getBody(), true);
            switch ($actualStatusCode) {
                case 400:
                    throw new BadRequestException([
                        'responseBody' => $body,
                    ]);
                case 401:
                    throw new UnauthorizedException([
                        'responseBody' => $body,
                    ]);
                case 403:
                    throw new ForbiddenException([
                        'responseBody' => $body,
                    ]);
                default:
                    throw new UnexpectedStatusCode(
                        $expectedStatusCode,
                        $actualStatusCode
                    );
            }
        }
    }
}
