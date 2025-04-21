<?php

namespace App\Constants;

class LeaveRequestStatus
{
    const REQUESTED = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;


    const ALL = [
        self::REQUESTED => 'Requested',
        self::ACCEPTED => 'Accepted',
        self::REJECTED => 'Rejected',
    ];

    const BOOTSTRAP_COLORS = [
        self::REQUESTED => 'primary',
        self::ACCEPTED => 'success',
        self::REJECTED => 'danger',
    ];
}
