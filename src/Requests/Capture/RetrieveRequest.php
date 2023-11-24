<?php

namespace Superscript\Loqate\Requests\Capture;

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Superscript\Loqate\Data\Address;

final class RetrieveRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $id
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/Capture/Interactive/Retrieve/v1.20/json3.ws';
    }

    public function defaultQuery(): array
    {
        return [
            'Id' => $this->id,
        ];
    }

    /**
     * @return Collection<array-key, Address>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return Address::collection($response->json('Items'));
    }
}
