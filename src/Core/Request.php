<?php

namespace Tamicktom\Lockbox\Core;

class Request
{
    /**
     * Summary of __construct
     * @param string $method
     * @param string $path
     * @param array<string, string> $queryParams
     * @param array<string, string> $headers
     * @param array<string, mixed> $bodyParams
     * @param ?array<string, mixed> $jsonBody
     */
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $queryParams,
        public readonly array $headers,
        public readonly array $bodyParams,
        public readonly ?array $jsonBody
    ) {
    }

    public static function fromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $headers = function_exists('getallheaders') ? (getallheaders() ?: []) : [];

        $contentType = strtolower($headers['Content-Type'] ?? $_SERVER['CONTENT_TYPE'] ?? '');
        $rawInput = file_get_contents('php://input') ?: '';
        $jsonBody = null;
        if (str_contains($contentType, 'application/json') && $rawInput !== '') {
            $decoded = json_decode($rawInput, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $jsonBody = $decoded;
            }
        }

        /** @var array<string, string> $queryParams */
        $queryParams = $_GET;
        /** @var array<string, mixed> $bodyParams */
        $bodyParams = $_POST;

        return new self(
            method: $method,
            path: rtrim($path, '/') === '' ? '/' : rtrim($path, '/'),
            queryParams: $queryParams,
            headers: $headers,
            bodyParams: $bodyParams,
            jsonBody: $jsonBody
        );
    }
}
