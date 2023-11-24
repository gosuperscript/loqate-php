<?php
declare(strict_types=1);

namespace Superscript\Loqate\Responses;

use Saloon\Http\Response;

class LoqateResponse extends Response
{
    public function failed(): bool
    {
        if (parent::failed()) {
            return false;
        }

        return ! empty($this->json('Items.0.Error'));
    }
}
