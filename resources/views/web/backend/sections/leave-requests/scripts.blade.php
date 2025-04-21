{{ $dataTable->scripts(attributes: ['type' => 'module']) }}


<script>
    /**
     * block enter key in textarea
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

    $(document).on('click', '.status_update_btn', function() {
        let request_id = $(this).attr('data-id');
        let data = [];

        $('#note').val('');
        $('#request_id').val('');
        $('#request_id').val(request_id);

            startLoader();
            $.ajax({
                url: '{{ route('request.getInfo', '%id%') }}'.replace('%id%', request_id),
                type: 'GET',
                dataType: "json", // We will receive data in Json format
                success: function(response) {

                data = response;
                console.log(data);

                $('#actions_select2').empty();
                $("#actions_select2").append($('<option>', {
                        'disabled':true,
                        'selected':true
                }));
                Object.entries(response.status).forEach(function ([key, value]) {
                    $("#actions_select2").append($('<option>', {
                        value: key,
                        text: value,
                        class: "class-name",
                        selected: key == response.leave_request.status ? true : false
                    }));
                });

                $('#latest_status_date').val(response.latest_updated_at);
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
                let request_id = $('#request_id').val();
                let note = $('#note').val();

                startLoader();
                $.ajax({
                    url: '{{ route('request.updateStatus') }}',
                    type: 'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        request_id: request_id,
                        status: action_id,
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
                            LaravelDataTables['leave-requests-table']?.ajax.reload()
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
