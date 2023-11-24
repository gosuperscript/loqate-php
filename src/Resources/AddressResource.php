<?php
declare(strict_types=1);

namespace Superscript\Loqate\Resources;

use Illuminate\Support\Collection;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Superscript\Loqate\Data\Feature;
use Superscript\Loqate\Requests\Capture\FindRequest;
use Superscript\Loqate\Requests\Capture\RetrieveRequest;
use Superscript\Loqate\Responses\Capture\FindResponse;

class AddressResource extends BaseResource
{
    /**
     * @return Collection<array-key, Feature>
     */
    public function find(
        string $text,
        string $container = null,
        bool $deduplicate = false,
        string $countryCode = null,
    ): Collection {
        return $this->connector->send(new FindRequest(
            text: $text,
            container: $container,
            deduplicate: $deduplicate,
            countryCode: $countryCode,
        ))->dtoOrFail();
    }

    public function retrieve(string $id): Collection
    {
        return $this->connector->send(new RetrieveRequest($id))->dtoOrFail();
    }
}
