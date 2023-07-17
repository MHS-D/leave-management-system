<?php

namespace App\Constants;

class ProjectStatus
{
    const CREATED = 0;
    const ONE_INPROGRESS = 1, ONE_DONE = 2;
    const TWO_INPROGRESS = 3, TWO_DONE = 4;
    const THREE_INPROGRESS = 5, THREE_DONE = 6;
    const FOUR_INPROGRESS = 7, FOUR_DONE = 8;


    const ALL = [
        self::CREATED => 'CREATED',
        self::ONE_INPROGRESS => 'ONE_INPROGRESS',
        self::ONE_DONE => 'ONE_DONE',
        self::TWO_INPROGRESS => 'TWO_INPROGRESS',
        self::TWO_DONE => 'TWO_DONE',
        self::THREE_INPROGRESS => 'THREE_INPROGRESS',
        self::THREE_DONE => 'THREE_DONE',
        self::FOUR_INPROGRESS => 'FOUR_INPROGRESS',
        self::FOUR_DONE => 'FOUR_DONE',
    ];

    const BOOTSTRAP_COLORS = [
        self::CREATED => 'warning',
        self::ONE_INPROGRESS => 'warning',
        self::ONE_DONE => 'success',
        self::TWO_INPROGRESS => 'warning',
        self::TWO_DONE => 'success',
        self::THREE_INPROGRESS => 'warning',
        self::THREE_DONE => 'success',
        self::FOUR_INPROGRESS => 'warning',
        self::FOUR_DONE => 'success',
    ];
}
