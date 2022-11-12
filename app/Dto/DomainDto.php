<?php

declare(strict_types=1);

namespace App\Dto;

use Carbon\Carbon;
use JsonSerializable;

class DomainDto implements JsonSerializable
{
    public function __construct(
        private string $domain,
        private string $host,
        private string $text,
        private ?Carbon $expired_at = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            domain: (string)$data['domain'],
            host: (string)$data['host'],
            text: (string)$data['text'],
            expired_at: Carbon::createFromTimestamp($data['expired_at']),
        );
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getExpiredAt(): ?Carbon
    {
        return $this->expired_at;
    }

    public function jsonSerialize()
    {
        return [
            'domain' => $this->getDomain(),
            'host' => $this->getHost(),
            'text' => $this->getText(),
            'expired_at' => $this->getExpiredAt()?->format('Y-m-d'),
        ];
    }
}
