<?php

namespace Superscript\Loqate\Requests\Capture;

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Superscript\Loqate\Data\Address;
use Webmozart\Assert\Assert;

final class RetrieveRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @var list<string>
     */
    private array $fields;

    public function __construct(
        public string $id,
        /** @var list<string> | array<string, string> */
        private array $with = [],
    ) {
        Assert::maxCount($with, 20, 'Loqate supports a maximum of 20 extra fields per request');

        if (array_is_list($this->with)) {
            $this->with = collect($this->with)->mapWithKeys(fn ($field) => [$field => sprintf('{%s}', self::studly($field))])->all();
        }

        $this->fields = array_keys($this->with);
    }

    public function resolveEndpoint(): string
    {
        return '/Capture/Interactive/Retrieve/v1.20/json3.ws';
    }

    public function defaultQuery(): array
    {
        return [
            'Id' => $this->id,
            ...collect($this->fields)->mapWithKeys(fn (string $field, int $index) => [
                sprintf("Field%dFormat", $index + 1) => $this->with[$field],
            ]),
        ];
    }

    /**
     * @return Collection<array-key, Address>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return Address::collection($response->json('Items'), fields: $this->fields);
    }

    private function studly(string $value): string
    {
        $words = explode(' ', str_replace(['-', '_'], ' ', $value));

        $studlyWords = array_map(fn ($word) => ucfirst($word), $words);

        return implode($studlyWords);
    }
}
