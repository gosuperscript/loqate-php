<?php

namespace Superscript\Loqate\Data;

use Illuminate\Support\Collection;
use stdClass;

final readonly class Address
{
    public function __construct(
        public string $id,
        public ?string $line1 = null,
        public ?string $line2 = null,
        public ?string $line3 = null,
        public ?string $line4 = null,
        public ?string $line5 = null,
        public ?string $street = null,
        public ?string $company = null,
        public ?string $buildingNumber = null,
        public ?string $buildingName = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?string $countryIso2 = null,
        public ?string $countryIso3 = null,
        public ?string $countryIsoNumber = null,
        public ?string $countryName = null,
        public stdClass $extra = new stdClass(),
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     * @param list<string> $fields
     */
    public static function fromArray(array $payload, array $fields): self
    {
        return new self(
            id: $payload['Id'],
            line1: $payload['Line1'] ?? null,
            line2: $payload['Line2'] ?? null,
            line3: $payload['Line3'] ?? null,
            line4: $payload['Line4'] ?? null,
            line5: $payload['Line5'] ?? null,
            street: $payload['Street'] ?? null,
            company: $payload['Company'] ?? null,
            buildingNumber: $payload['BuildingNumber'] ?? null,
            buildingName: $payload['BuildingName'] ?? null,
            postalCode: $payload['PostalCode'] ?? null,
            city: $payload['City'] ?? null,
            countryIso2: $payload['CountryIso2'] ?? null,
            countryIso3: $payload['CountryIso3'] ?? null,
            countryIsoNumber: $payload['CountryIsoNumber'] ?? null,
            countryName: $payload['CountryName'] ?? null,
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
