{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>
    /**
     * Initiate the user CRUD functionality with modal and ajax
     */
    crudModal({
        create_btn: '.btn-create',
        update_btn: '.btn-update',
        modal: '#crud-modal',
        title: {
            selector: '#crud-modal .modal-title',
            value: {
                create: '{{ __('strings.ADD_USER') }}',
                update: '{{ __('strings.UPDATE_USER') }}',
            }
        },
        submit_btn: {
            selector: '.btn-submit',
            text: {
                create: '{{ __('strings.ADD_USER') }}',
                update: '{{ __('strings.UPDATE_USER') }}',
            }
        },
        submit_validation: {
            rules: {
                'first_name': {
                    required: true
                },
                'last_name': {
                    required: true
                },
                'phone': {
                    required: true
                },
                'status': {
                    required: true
                },
                // 'password': { // TODO: We need to find a way to separate "create" & "update" validations
                // 	required: true,
                // 	minlength: 8,
                // },
                // 'password_confirmation': {
                // 	required: true,
                // 	equalTo: "#password"
                // },
            }
        },
        functions: {
            onSubmitBtnClicked: {
                success: {
                    after: function() {
                        getStatistics();
                    }
                }
            },
            onUpdateBtnClicked: {
                success: {
                    before: function(data) {
                        $('#permissions-by-role__div input').prop('checked', data.direct_permissions
                        .length == 0)
                        // checkRolesPermissionsDivVisibility();

                        let selectedPermissionsIds = [];
                        data.all_permissions.forEach(permission => {
                            selectedPermissionsIds.push(permission.id);
                        })
                        $('#permissions').val(selectedPermissionsIds)

                        setTimeout(() => {
                            // We need to wait a little bit until the values are changes so the "height" logic in the for the "multiple select2" works
                            $('#permissions').change()
                        }, 500);
                    }
                }
            }
        },
        url: {
            create: '{{ route('users.store') }}',
            edit: '{{ route('users.show', '%data_id%') }}',
            update: '{{ route('users.update', '%data_id%') }}',
            id_replace_key: '%data_id%', // Replace this string with the data id
        },
        result_key: 'data',
        actions: {
            submit: {
                success: {
                    action: 'reload-dataTable'
                }
            }
        },
        dataTableId: 'users-table',
        inputs: [{
                selector: '#first-name',
                result_key: 'first_name'
            },
            {
                selector: '#last-name',
                result_key: 'last_name'
            },
            {
                selector: '#username',
                result_key: 'username'
            },
            {
                selector: '#phone',
                result_key: 'phone'
            },
            {
                selector: '#nationality',
                result_key: 'nationality'
            },
            {
                selector: '#status',
                result_key: 'status'
            },
            {
                selector: '#role',
                result_key: 'role'
            },
        ],
    });

    /**
     * Get users statistics
     */
    function getStatistics() {
        startLoader();

        $.ajax({
            url: '{{ route('users.statistics') }}',
            dataType: "json", // We will receive data in Json format
            success: function(response) {
                $('.users-statistics').html(response.data.html)
            },
            error: function(xhr, textStatus, errorThrown) {
                ajaxErrorDisplay(xhr, textStatus, errorThrown)
            }
        }).always(function() {
            stopLoader();
        });
    }
    getStatistics();

    $(document).on('click', '.btn-create', function() {
        $('#permissions-by-role__div').addClass('d-none');
        $('#permissions-by-role__div input').prop('disabled', true)

        $('#permissions__div').addClass('d-none');
        $('#permissions__div select').prop('disabled', true)
    })

    $(document).on('click', '.btn-update', function() {
        $('#permissions-by-role__div').removeClass('d-none');
        $('#permissions-by-role__div input').prop('disabled', false)

        // checkRolesPermissionsDivVisibility();
    })


            // const textarea = document.getElementById("notification_message");

            textarea.addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
            });

</script>
