<?php

declare(strict_types=1);

namespace Superscript\Loqate;

use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Superscript\Loqate\Resources\AddressResource;
use Superscript\Loqate\Responses\LoqateResponse;

class Loqate extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    protected ?string $response = LoqateResponse::class;

    public function __construct(string $apiKey)
    {
        $this->withQueryAuth('Key', $apiKey);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.addressy.com/';
    }

    public function address(): AddressResource
    {
        return new AddressResource($this);
    }
}
