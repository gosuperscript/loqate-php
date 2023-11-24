<?php

namespace Superscript\Loqate\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class Address
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $line1,
        public readonly ?string $line2,
        public readonly ?string $line3,
        public readonly ?string $line4,
        public readonly ?string $line5,
        public readonly ?string $street,
        public readonly ?string $company,
        public readonly ?string $buildingNumber,
        public readonly ?string $buildingName,
        public readonly ?string $postalCode,
        public readonly ?string $city,
        public readonly ?string $countryIso2,
        public readonly ?string $countryIso3,
        public readonly ?string $countryIsoNumber,
        public readonly ?string $countryName,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
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
     * @return Collection<array-key, self>
     */
    public static function collection(iterable $items): Collection
    {
        return Collection::make($items)->map(fn (array $item) => self::fromArray($item));
    }
}
