<?php

namespace App;

class InMemoryRequestMethodStorer
{
    private const ORIGINAL_REQUEST_METHOD_KEY = 'original';
    private const ERROR_CONTROLLER_REQUEST_METHOD_KEY = 'error_controller';
    private array $requestMethodOccurrences;

    public function addOriginalRequestMethodOccurrence(string $requestMethod): void
    {
        $this->requestMethodOccurrences[self::ORIGINAL_REQUEST_METHOD_KEY][] = $requestMethod;
    }

    public function addErrorControllerRequestMethodOccurrence(string $requestMethod): void
    {
        $this->addRequestMethodOccurrence(self::ERROR_CONTROLLER_REQUEST_METHOD_KEY, $requestMethod);
    }

    public function getOriginalRequestMethodOccurrences(): array
    {
        return $this->getRequestMethodOccurrences(self::ORIGINAL_REQUEST_METHOD_KEY);
    }

    public function getErrorControllerRequestMethodOccurrences(): array
    {
        return $this->getRequestMethodOccurrences(self::ERROR_CONTROLLER_REQUEST_METHOD_KEY);
    }

    private function addRequestMethodOccurrence(string $key, string $requestMethod): void
    {
        $this->requestMethodOccurrences[$key][] = $requestMethod;
    }

    private function getRequestMethodOccurrences(string $key): array
    {
        return $this->requestMethodOccurrences[$key] ?? [];
    }

    public function clearRequestMethodOccurrences(): void
    {
        $this->requestMethodOccurrences = [];
    }
}