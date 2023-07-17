@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#projects-table').DataTable({
                // Your datatable initialization options
            });

            table.on('search.dt', function() {
                var totalBudget = table.column(11, { search: 'applied' }).data().sum();

                $("tfoot tr>th:nth-child(12)").text("Total");
                $('tfoot tr>th:nth-child(11)').text(totalBudget);
            });
        });
    </script>
@endpush

<script>
    /**
     * Add offer button click handler
     */
    $(document).on('click', '.btn-create', function() {
        window.location = $(this).attr('href')
    })

    var textarea = document.getElementById("note");

    textarea.addEventListener("keydown", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });

       /**
     * Add project update status button click handler
     */
     $(document).on('click', '.status_update_btn', function() {
        let project_id = $(this).attr('data-id');
        let data = [];

        $('#note').val('');
        $('#project_id').val('');
        $('#project_id').val(project_id);

        $('.department_list_div').addClass('d-none');
        $('#departments_list').attr('disabled', true);
        $('#departments_list').attr('required', false);

            // get product info
            startLoader();
            $.ajax({
                url: '{{ route('project.getInfo') }}',
                type: 'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    project_id: project_id
                },
                dataType: "json", // We will receive data in Json format
                success: function(response) {

                data = response;

                $('#actions_select2').empty();
                $("#actions_select2").append($('<option>', {
                        'disabled':true,
                        'selected':true
                }));
                Object.entries(response.allowed_actions).forEach(function ([key, value]) {
                    $("#actions_select2").append($('<option>', {
                        value: value.id,
                        text: value.name,
                        class: "class-name",
                        selected: value.id == response.selected_status ? true : false
                    }));
                });

                $('#latest_status_date').val(response.latest_updated_at);

                if(response.enable_list_at_done == true){
                    $(document).on('change', '#actions_select2', function(data) {
                    let action_id = $(this).val();

                    if(action_id == response.enable_list_at_done_action_id){
                        $('.department_list_div').removeClass('d-none');

                        $('#departments_list').attr('disabled', false);
                        $('#departments_list').attr('required', true);

                        $('#departments_list').empty();
                        $("#departments_list").append($('<option>', {
                                'disabled':true,
                                'selected':true
                        }));

                        Object.entries(response.list_users).forEach(function ([key, value]) {
                            $("#departments_list").append($('<option>', {
                                value: value.id,
                                text: value.first_name + ' ' + value.last_name,
                            }));
                        });
                    }else{
                        $('.department_list_div').addClass('d-none');
                        $('#departments_list').attr('disabled', true);
                        $('#departments_list').attr('required', false);
                    }

                    });
                }
                },
                error: function(xhr, textStatus, errorThrown) {
                    ajaxErrorDisplay(xhr, textStatus, errorThrown)
                }
            }).always(function() {
                stopLoader();
            });
    })

    $(document).on('click','.update_status_action', function(e){
                e.preventDefault();
                let action_id = $('#actions_select2').val();
                let department_id = $('#departments_list').val();
                let project_id = $('#project_id').val();
                let note = $('#note').val();

                startLoader();
                $.ajax({
                    url: '{{ route('project.updateStatus') }}',
                    type: 'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        project_id: project_id,
                        action_id: action_id,
                        department_id: department_id,
                        note: note
                    },
                    dataType: "json", // We will receive data in Json format
                    success: function(response) {
                        stopLoader();
                        if(response.success == true){
                            $('#update_status_modal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Sent!',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            LaravelDataTables['projects-table']?.ajax.reload()
                           }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        ajaxErrorDisplay(xhr, textStatus, errorThrown)
                    }
                }).always(function() {
                    stopLoader();
                });

    })

    // additional info
    $(document).on('click', '.status_update_info', function() {
        let project_id = $(this).attr('data-id');
        let data = [];

        $('#project_id').val('');
        $('#project_id').val(project_id);

            // get product info
            startLoader();
            $.ajax({
                url: '{{ route('project.getInfo') }}',
                type: 'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    project_id: project_id
                },
                dataType: "json", // We will receive data in Json format
                success: function(response) {

                data = response;

                $('#assignment_book_number').val(response.project.assignment_book_number);
                $('#assignment_book_date').val(response.project.assignment_book_date);
                $('#assignment_book_submition_day').val(response.project.assignment_book_submition_day);
                $('#contract_book_number').val(response.project.contract_book_number);
                $('#contract_book_date').val(response.project.contract_book_date);
                $('#signature_date').val(response.project.signature_date);
                $('#work_starting_date').val(response.project.work_starting_date);

                },
                error: function(xhr, textStatus, errorThrown) {
                    ajaxErrorDisplay(xhr, textStatus, errorThrown)
                }
            }).always(function() {
                stopLoader();
            });
    })

    $(document).on('click','.update_info_action', function(e){
                e.preventDefault();
                let project_id = $('#project_id').val();

                startLoader();
                $.ajax({
                    url: '{{ route('projects.update', '%project_id%') }}'.replace('%project_id%', project_id),
                    type: 'PUT',
                    data: {
                        _token : '{{ csrf_token() }}',
                        assignment_book_number: $('#assignment_book_number').val(),
                        assignment_book_date: $('#assignment_book_date').val(),
                        assignment_book_submition_day: $('#assignment_book_submition_day').val(),
                        contract_book_number: $('#contract_book_number').val(),
                        contract_book_date: $('#contract_book_date').val(),
                        signature_date: $('#signature_date').val(),
                        work_starting_date: $('#work_starting_date').val(),
                    },
                    dataType: "json", // We will receive data in Json format
                    success: function(response) {
                        stopLoader();
                        if(response.success == true){
                            $('#update_info_modal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Sent!',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            LaravelDataTables['projects-table']?.ajax.reload()
                           }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        ajaxErrorDisplay(xhr, textStatus, errorThrown)
                    }
                }).always(function() {
                    stopLoader();
                });

    })
</script>
