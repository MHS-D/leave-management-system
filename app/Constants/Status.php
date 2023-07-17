<?php

namespace App\Constants;

class Status
{
    const UNACTIVE = 1;
    const ACTIVE = 2;

    const ALL = [
        Status::ACTIVE => 'ACTIVE',
        Status::UNACTIVE => 'UNACTIVE',
    ];

    const BAGDE_MAP = [
        'UNACTIVE' => 'warning',
        'ACTIVE' => 'success',
    ];
}
