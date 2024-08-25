<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\DTO;

readonly class CompanyDTO
{
    /**
     * @param int $userId
     * @param string $name
     * @param string $status
     */
    public function __construct(
        public int $userId,
        public string $name,
        public string $status
    ) {}
}