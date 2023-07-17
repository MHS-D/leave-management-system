<?php

namespace App\Exports;

use App\Constants\Status;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    protected $usersIds = [];

    public function __construct(array $usersIds)
    {
        $this->usersIds = $usersIds;
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Username',
            'Status',
            'Role',
        ];
    }

    public function map($user): array
    {
        return [
            $user->first_name,
            $user->last_name,
            $user->username,
            ucfirst(Status::ALL[$user->status] ?? '---'),
            ucfirst($user->role ?? '---'),
        ];
    }

    public function query()
    {
        return User::query()->with(['latestTransaction', 'roles'])->whereIn('id', $this->usersIds)->latest();
    }
}
