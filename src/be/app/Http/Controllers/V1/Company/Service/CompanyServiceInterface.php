<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Service;

use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use Illuminate\Http\Request;

interface CompanyServiceInterface
{
    /**
     * @param Request $request
     * @param bool $includeTasks
     * @param int $perPage
     * @return CompanyCollection
     */
    public function getCompanies(Request $request,
                                 ?bool    $includeTasks,
                                 int     $perPage): CompanyCollection;
//    public function findByUserId(User $user): Company;
//    public function findByCompanyId(User $phone): Company;
//    public function create(string $name, Phone $phone): Company;
//    public function deleteById(int $id): void;
}