<?php

namespace Tamicktom\Lockbox\Core;

class Response
{
    private int $statusCode = 200;
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

    public function json(array $data): void
    {
        $this->header('Content-Type', 'application/json; charset=utf-8');
        $this->send(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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
