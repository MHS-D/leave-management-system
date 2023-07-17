<!-- BEGIN: Vendor JS-->
<script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets//vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('assets//vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>

<script src="{{ asset('assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('assets/js/core/app.js') }}"></script>
<script src="{{ asset('assets/js/core/loader.js') }}"></script>
<!-- END: Theme JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    /**
     * Mask number inputs
     */
    function maskNumericalInputs() {
        let numeralMask = $('.numeral-mask')
        if (numeralMask.length > 0) {
            numeralMask.each(function() {
                new Cleave($(this), {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
            })
        }
    }
    maskNumericalInputs()

    /**
     * select2 initializing
     */
    $('.select2').each(function() {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent(),
            closeOnSelect: !$this.prop('multiple')
        });
    }).on('change', function() {
        let ul = $(this).parent().find('.select2 .select2-selection ul');
        if (ul.length == 0) {
            return;
        }

        let height = ul.height();

        if (height > 40) {
            let selected = $(this).val().length;
            let of = $(this).find('option').length;
            ul.html(
                `<span class="d-block" style="padding-top: 5px">Selected ${selected} of ${of} items.</span>`
            )
        }
    });

    /**
     * Datatable row selection
     */
    const selectedClass = 'selected';
    const datatablesSelectedRowsIds = {};
    $(document).on('click', 'table.row-selection tr .row-selection__checkbox', function() {
        const tableId = $(this).closest('table').attr('id');
        if (!tableId) {
            return;
        }

        const row = $(this).closest('tr');
        const dataId = row.attr('data-id');

        const isChecked = $(this).is(':checked')

        if (!datatablesSelectedRowsIds[tableId]) {
            datatablesSelectedRowsIds[tableId] = [];
        }

        if (isChecked) {
            selectRow(tableId, dataId)
        } else {
            unselectRow(tableId, dataId)
        }

        checkAllRowsSelected(tableId)
    })
    $(document).on('click', 'table.row-selection tr .row-selection__checkbox--all', function() {
        const table = $(this).closest('table');
        const tableId = table.attr('id');
        if (!tableId) {
            return;
        }

        if (areAllVisibleRowsSelected(tableId)) {
            unselectAllVisibleRows(tableId)
        } else {
            selectAllVisibleRows(tableId)
        }

        checkAllRowsSelected(tableId)
    })

    function checkSelectedRows() {
        Object.entries(datatablesSelectedRowsIds ?? {}).forEach(([tableId, rowIds]) => {
            console.log(datatablesSelectedRowsIds[tableId])
            const table = $('#' + tableId)
            if (!table) {
                return null;
            }

            (rowIds ?? []).forEach(rowId => {
                selectRow(tableId, rowId)
            })

            checkAllRowsSelected(tableId)
        })

    }

    function selectRow(tableId, rowDataId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        if (!datatablesSelectedRowsIds[tableId]) {
            datatablesSelectedRowsIds[tableId] = [];
        }

        let index = datatablesSelectedRowsIds[tableId].includes(rowDataId);
        if (index === false) {
            datatablesSelectedRowsIds[tableId].push(rowDataId);
        }

        table.find(`tbody tr[data-id="${rowDataId}"]`).addClass(selectedClass)
        table.find(`tbody tr[data-id="${rowDataId}"] .row-selection__checkbox`).prop('checked', true)
    }

    function unselectRow(tableId, rowDataId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        if (!datatablesSelectedRowsIds[tableId]) {
            datatablesSelectedRowsIds[tableId] = [];
        }

        let index = datatablesSelectedRowsIds[tableId].indexOf(rowDataId);
        if (index >= 0) {
            datatablesSelectedRowsIds[tableId].splice(index, 1);
        }

        table.find(`tbody tr[data-id="${rowDataId}"]`).removeClass(selectedClass)
        table.find(`tbody tr[data-id="${rowDataId}"] .row-selection__checkbox`).prop('checked', false)
    }

    function getSelectedRowsCount(tableId) {
        return datatablesSelectedRowsIds[tableId] ? datatablesSelectedRowsIds[tableId].length : 0;
    }

    function getUnselectedVisibleRowsCount(tableId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        return table.find(`tbody tr:not(.${selectedClass})`).length
    }

    function getAllVisibleRowsCount(tableId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        return table.find('tbody tr').length
    }

    function selectAllVisibleRows(tableId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        table.find(`tbody tr`).each(function() {
            selectRow(tableId, $(this).attr('data-id'))
        })
    }

    function unselectAllVisibleRows(tableId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        table.find(`tbody tr`).each(function() {
            unselectRow(tableId, $(this).attr('data-id'))
        })
    }

    function areAllVisibleRowsSelected(tableId) {
        return getAllVisibleRowsCount(tableId) > 0 && getUnselectedVisibleRowsCount(tableId) === 0;
    }

    function checkAllRowsSelected(tableId) {
        const table = $('#' + tableId)
        if (!table) {
            return null;
        }

        let _areAllVisibleRowsSelected = areAllVisibleRowsSelected(tableId)
        if (_areAllVisibleRowsSelected) {
            table.find('.row-selection__checkbox--all').prop('checked', true)
        } else {
            table.find('.row-selection__checkbox--all').prop('checked', false)
        }

        displaySelectedRowsCountDiv(tableId)

        return _areAllVisibleRowsSelected;
    }

    function displaySelectedRowsCountDiv(tableId) {
        const tableWrapper = $(`#${tableId}_wrapper`);
        const selectedRowsCount = getSelectedRowsCount(tableId);

        tableWrapper.find('.row-selection__text').remove()
        if (selectedRowsCount > 0) {
            tableWrapper.find('.dataTables_info').first().after(
                `<div class="row dataTables_info row-selection__text"><div class="col">Selected Rows: ${selectedRowsCount}</div></div>`
            )
        }
    }

    /**
     * Export Excel
     */
    $(document).on('click', '.export-selected-rows', function() {
        let tableId = $(this).closest('.dataTables_wrapper').find('table').attr('id');
        let selectedIds = datatablesSelectedRowsIds[tableId] ?? []
        if (selectedIds.length == 0) {
            notify('warning', 'Select rows first')
            return;
        }

        startLoader();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", $(this).attr('href'), true);
        xhr.responseType = "blob";
        xhr.onload = function() {
            if (this.status === 200) {
                downloadBlob(xhr, this.response);
            } else {
                notify('error', xhr.statusText)
            }

            stopLoader();
        };

        let data = {
            ids: datatablesSelectedRowsIds[tableId]
        }

        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        xhr.setRequestHeader("Content-type", "application/json");

        xhr.send(JSON.stringify(data));
    });

    /**
     * Download blob from xhr request
     */
    function downloadBlob(xhr, blob) {
        let disposition = xhr.getResponseHeader('Content-Disposition');
        let fileName = disposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/)[1] ?? null;
        
        if (!fileName) {
            return;
        }
        
        // Remove "Double Quotes" from filename
        fileName = fileName.replace(/\"/g, "");

        let a = document.createElement("a");
        a.href = URL.createObjectURL(blob);
        a.download = fileName;
        a.click();
    }
</script>

@stack('scripts')
