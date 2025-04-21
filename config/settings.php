<?php

use App\Constants\LeaveRequestStatus;
use Illuminate\Http\Request;

return [
    'defualt' => [
        'title' => 'leave Management System',
    ],

    'roles' => [

        'names' => [
            'adminRole' => 'admin' ,
            'employeeRole' => 'employee' ,
        ],

    ],

        'actions' => [
            'assignRole' => 'assign',
            'removeRole' => 'remove',
        ],

];

?>
