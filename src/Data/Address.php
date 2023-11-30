<?php

namespace Superscript\Loqate\Data;

use Illuminate\Support\Collection;
use stdClass;

final readonly class Address
{
    public function __construct(
        public string $id,
        public ?string $line1,
        public ?string $line2,
        public ?string $line3,
        public ?string $line4,
        public ?string $line5,
        public ?string $street,
        public ?string $company,
        public ?string $buildingNumber,
        public ?string $buildingName,
        public ?string $postalCode,
        public ?string $city,
        public ?string $countryIso2,
        public ?string $countryIso3,
        public ?string $countryIsoNumber,
        public ?string $countryName,
        public stdClass $extra,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     * @param list<string>
     */
    public static function fromArray(array $payload, array $fields): self
    {
        return new self(
            id: $payload['Id'],
            line1: $payload['Line1'],
            line2: $payload['Line2'],
            line3: $payload['Line3'],
            line4: $payload['Line4'],
            line5: $payload['Line5'],
            street: $payload['Street'],
            company: $payload['Company'],
            buildingNumber: $payload['BuildingNumber'],
            buildingName: $payload['BuildingName'],
            postalCode: $payload['PostalCode'],
            city: $payload['City'],
            countryIso2: $payload['CountryIso2'],
            countryIso3: $payload['CountryIso3'],
            countryIsoNumber: $payload['CountryIsoNumber'],
            countryName: $payload['CountryName'],
            extra: (object) collect($fields)
                ->mapWithKeys(fn (string $field, int $index) => [$field => $payload[sprintf('Field%d', $index + 1)]])
                ->all(),
        );
    }

    public function __toString(): string
    {
        return implode("\n", array_filter([
            $this->line1,
            $this->line2,
            $this->line3,
            "$this->postalCode $this->city",
            $this->countryName,
        ]));
    }

    /**
     * @param list<string> $fields
     * @return Collection<array-key, self>
     */
    public static function collection(iterable $items, array $fields = []): Collection
    {
        return Collection::make($items)->map(fn (array $item) => self::fromArray($item, $fields));
    }
}
