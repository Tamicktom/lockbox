<?php

namespace Tamicktom\Lockbox\Core;

class Response
{
    /** @var int $statusCode */
    private int $statusCode = 200;
    /** @var array<string, string> $headers */
    private array $headers = [];

    public function status(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Summary of json
     * @param array<string, mixed> $data
     * @return void
     */
    public function json(array $data): void
    {
        $this->header('Content-Type', 'application/json; charset=utf-8');
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json == false) {
            throw new \RuntimeException('Failed to encode JSON');
        }
        $this->send((string) $json);
    }

    public function send(string $content): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }
        echo $content;
    }
}
