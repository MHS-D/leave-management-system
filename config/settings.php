<?php

use App\Constants\ProjectStatus;
use Illuminate\Http\Request;

return [
    'defualt' => [
        'title' => 'Project Management System',
    ],

    'roles' => [

        'names' => [
            'adminRole' => 'admin' ,
            'department1Role' => 'department1' ,
            'department2Role' => 'department2' ,
            'department3Role' => 'department3' ,
            'department4Role' => 'department4' ,
            'department5Role' => 'department5' ,
            'department6Role' => 'department6' ,
            'subAdminRole' => 'subadmin' ,
        ],

        'allowed_statuses' => [
            'department1' => [
                'view' => [
                    ProjectStatus::CREATED,
                    ProjectStatus::ONE_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::ONE_INPROGRESS,
                    ProjectStatus::ONE_DONE,
                ],
            ],
            'department2' => [
                'view' => [
                    ProjectStatus::ONE_DONE,
                    ProjectStatus::TWO_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::TWO_INPROGRESS,
                    ProjectStatus::TWO_DONE,
                ],
            ],
            'department3' => [
                'view' => [
                    ProjectStatus::ONE_DONE,
                    ProjectStatus::TWO_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::TWO_INPROGRESS,
                    ProjectStatus::TWO_DONE,
                ],
            ],
            'department4' => [
                'view' => [
                    ProjectStatus::ONE_DONE,
                    ProjectStatus::TWO_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::TWO_INPROGRESS,
                    ProjectStatus::TWO_DONE,
                ],
            ],
            'department5' => [
                'view' => [
                    ProjectStatus::TWO_DONE,
                    ProjectStatus::THREE_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::THREE_INPROGRESS,
                    ProjectStatus::THREE_DONE,
                ],
            ],
            'department6' => [
                'view' => [
                    ProjectStatus::THREE_DONE,
                    ProjectStatus::FOUR_INPROGRESS,
                ],
                'actions' => [
                    ProjectStatus::FOUR_INPROGRESS,
                    ProjectStatus::FOUR_DONE,
                ],
            ],
            'subadmin' => [
                'view' => [
                    ProjectStatus::CREATED,
                ],
            ],
        ],

        'chosen_departments' => [
            'department2',
            'department3',
            'department4',
        ],

        'actions' => [
            'assignRole' => 'assign',
            'removeRole' => 'remove',
        ],
    ],

];

?>
