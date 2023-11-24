<?php

namespace Superscript\Loqate\Requests\Capture;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Superscript\Loqate\Data\Feature;

final class FindRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $text,
        public ?string $container = null,
        public bool $deduplicate = false,
        public ?string $countryCode = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/Capture/Interactive/Find/v1.10/json3.ws';
    }

    public function defaultQuery(): array
    {
        return [
            'Text' => $this->text,
            'Container' => $this->container,
            'Countries' => $this->countryCode,
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Feature::collection($response->json('Items'));
    }
}
