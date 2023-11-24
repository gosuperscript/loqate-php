<?php

namespace Superscript\Loqate\Data;

use Illuminate\Support\Collection;

final readonly class Feature
{
    public function __construct(
        public string $id,
        public string $type,
        public string $text,
        public string $highlight,
        public string $description,
    ) {
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            id: $array['Id'],
            type: $array['Type'],
            text: $array['Text'],
            highlight: $array['Highlight'],
            description: $array['Description'],
        );
    }

    /**
     * @return Collection<array-key, self>
     */
    public static function collection(iterable $items): Collection
    {
        return Collection::make($items)->map(fn (array $item) => self::fromArray($item));
    }
}
