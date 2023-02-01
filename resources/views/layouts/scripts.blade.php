<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
{{--    $.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('plugins/ekko/ekko-lightbox.min.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>--}}

<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/locale/ru.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>


<script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: false,
                wrapping: false
            });
        });
    })
</script>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $(function () {
            bsCustomFileInput.init();
        });

        //Date range picker
        $('#reservation').daterangepicker({
            // startDate: moment().startOf('month'),
            // endDate: moment().endOf('month'),
            autoUpdateInput: false,
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Неделя': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
                'Месяц': [moment().startOf('month'), moment().endOf('month')],
                'Последние 7 дей': [moment().subtract(6, 'days'), moment()],
                'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                'Последний месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Очистить',
                applyLabel: 'Принять',
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                firstDay: 1,
            },
        })
        $('#reservation').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('#reservation').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        $('#reservation2').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#reservation3').daterangepicker({
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Неделя': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
                'Месяц': [moment().startOf('month'), moment().endOf('month')],
                'Последние 7 дей': [moment().subtract(6, 'days'), moment()],
                'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                'Последний месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            alwaysShowCalendars: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Очистить',
                applyLabel: 'Принять',
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                firstDay: 1,
            },
        })

        @if (isset($message))
        @if ($message->plan)
        $('#reservationdate').datetimepicker({
            defaultDate: "{{ $message->plan }}",
            format: 'YYYY-MM-DD',
        });
        @else
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        @endif
        @endif

        let messages = $('.yajra-datatable').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            autoWidth: false,
            pagingType: 'simple_numbers',
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[50, 100, -1], [50, 100, "Все"]],
            ajax: "{{ $data['request'] ?? '' }}",
            autoFill: {
                enable: true
            },
            order: [
                [0, 'desc']
            ],
            columns: [
                {
                    data: 'id',
                    name: 'm.id'
                },
                {
                    data: 'fio',
                    name: 'm.fio'
                },
                {
                    data: 'address',
                    name: 'm.address'
                },
                {
                    data: 'house',
                    name: 'm.house'
                },
                {
                    data: 'phone',
                    name: 'm.phone'
                },
                {
                    data: 'rname',
                    name: 'r.name'
                },
                {
                    data: 'sname',
                    name: 's.name'
                },
                {
                    data: 'idNumber',
                    name: 'idNumber',
                    orderable: false,
                    searchable: false

                },
                {
                    data: 'contractStatus',
                    name: 'contractStatus',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'photoStatus',
                    name: 'photoStatus',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'closed',
                    name: 'm.closed',
                },
                {
                    data: 'updated_at',
                    name: 'm.updated_at',
                },
                {
                    data: 'plan',
                    name: 'm.plan'
                },
                {
                    data: 'uid',
                    name: 'm.uid',
                    visible: false,
                },
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'dt-body-center'
                },
                {
                    targets: 1,
                    className: 'dt-body-center'
                },
                {
                    targets: 3,
                    className: 'dt-body-center'
                },
                {
                    targets: 4,
                    className: 'dt-body-center'
                },
                {
                    targets: 5,
                    className: 'dt-body-center'
                },
                {
                    targets: 6,
                    className: 'dt-body-center'
                },
                {
                    targets: 8,
                    className: 'dt-body-center'
                },
                {
                    targets: 9,
                    className: 'dt-body-center'
                },
                {
                    targets: -3,
                    className: 'dt-body-center',
                },
                {
                    targets: -2,
                    className: 'dt-body-center',
                },
                {
                    targets: -1,
                    className: 'dt-body-center'
                },

            ],

        });
        let appeals = $('.yajra-datatable-appeals').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            autoWidth: false,
            pagingType: 'simple_numbers',
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[50, 100, -1], [50, 100, "Все"]],
            ajax: "{{ route('appeals.list') }}",
            autoFill: {
                enable: true
            },
            order: [
                [0, 'desc']
            ],
            columns: [
                {
                    data: 'id',
                    name: 'a.id'
                },
                {
                    data: 'fio',
                    name: 'm.fio'
                },
                {
                    data: 'address',
                    name: 'a.address'
                },
                {
                    data: 'house',
                    name: 'a.house'
                },
                {
                    data: 'phone',
                    name: 'a.phone'
                },
                {
                    data: 'ip',
                    name: 'a.ip'
                },
                {
                    data: 'agreed',
                    name: 'a.agreed'
                },
                {
                    data: 'created_at',
                    name: 'a.created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'dt-body-center'
                },
                {
                    targets: 1,
                    className: 'dt-body-center'
                },
                {
                    targets: 3,
                    className: 'dt-body-center'
                },
                {
                    targets: 4,
                    className: 'dt-body-center'
                },
                {
                    targets: 5,
                    className: 'dt-body-center'
                },
                {
                    targets: 6,
                    className: 'dt-body-center'
                },
                {
                    targets: 8,
                    className: 'dt-body-center'
                },
                {
                    targets: 9,
                    className: 'dt-body-center'
                },
                {
                    targets: -3,
                    className: 'dt-body-center',
                },
                {
                    targets: -2,
                    className: 'dt-body-center',
                },
                {
                    targets: -1,
                    className: 'dt-body-center'
                },

            ],

        });
        let operations = $('.yajra-datatable-operations').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            autoWidth: false,
            pagingType: 'simple_numbers',
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[50, 100, -1], [50, 100, "Все"]],
            ajax: "{{ $data['request'] ?? '' }}",
            autoFill: {
                enable: true
            },
            order: [
                [0, 'desc']
            ],
            columns: [
                {
                    data: 'id',
                    name: 'm.id'
                },
                {
                    data: 'fio',
                    name: 'm.fio'
                },
                {
                    data: 'address',
                    name: 'm.address'
                },
                {
                    data: 'house',
                    name: 'm.house'
                },
                {
                    data: 'phone',
                    name: 'm.phone'
                },
                {
                    data: 'rname',
                    name: 'r.name'
                },
                {
                    data: 'sname',
                    name: 's.name'
                },
                {
                    data: 'idNumber',
                    name: 'idNumber',
                    orderable: false,
                    searchable: false

                },
                {
                    data: 'contractStatus',
                    name: 'contractStatus',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'photoStatus',
                    name: 'photoStatus',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'closed',
                    name: 'm.closed',
                },
                {
                    data: 'plan',
                    name: 'm.plan'
                },
                {
                    data: 'uid',
                    name: 'm.uid',
                    visible: false,
                },
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'dt-body-center'
                },
                {
                    targets: 1,
                    className: 'dt-body-center'
                },
                {
                    targets: 3,
                    className: 'dt-body-center'
                },
                {
                    targets: 4,
                    className: 'dt-body-center'
                },
                {
                    targets: 5,
                    className: 'dt-body-center'
                },
                {
                    targets: 6,
                    className: 'dt-body-center'
                },
                {
                    targets: 8,
                    className: 'dt-body-center'
                },
                {
                    targets: 9,
                    className: 'dt-body-center'
                },
                {
                    targets: -3,
                    className: 'dt-body-center',
                },
                {
                    targets: -2,
                    className: 'dt-body-center',
                },
                {
                    targets: -1,
                    className: 'dt-body-center'
                },

            ],

        });
        let userReport = $('.yajra-datatable-user-report').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            pagingType: 'simple',
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[50, 100, -1], [50, 100, "Все"]],
            ajax: "{{ $data['request-user-report'] ?? '' }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'opened_count',
                    name: 'opened_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'done_count',
                    name: 'done_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'closed_count',
                    name: 'closed_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'edit_count',
                    name: 'edit_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'plan_count',
                    name: 'plan_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'checked_count',
                    name: 'checked_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'moneywait_count',
                    name: 'moneywait_count',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'paid_count',
                    name: 'paid_count',
                    orderable: true,
                    searchable: false,
                },

            ]
        });
        let users = $('.yajra-datatable-users').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            pagingType: 'simple_numbers',
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [[-1], ["Все"]],
            ajax: "{{ route('users.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'role',
                    name: 'role',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'master.name',
                    name: 'master.name',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },

            ]
        });
        let types = $('.yajra-datatable-type').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            pagingType: 'simple',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('types.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'admin.name',
                    name: 'admin.name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        let status = $('.yajra-datatable-status').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            pagingType: 'simple',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('status.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'type_id',
                    name: 'type_id'
                },
                {
                    data: 'admin.name',
                    name: 'admin.name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        let roles = $('.yajra-datatable-roles').DataTable({
            language: {
                "processing": "Подождите...",
                "search": "Поиск:",
                "lengthMenu": "Показать _MENU_ записей",
                "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                "infoEmpty": "Записи с 0 до 0 из 0 записей",
                "infoFiltered": "(отфильтровано из _MAX_ записей)",
                "infoPostFix": "",
                "loadingRecords": "Загрузка записей...",
                "zeroRecords": "Записи отсутствуют.",
                "emptyTable": "В таблице отсутствуют данные",
                "paginate": {
                    "first": "Первая",
                    "previous": "Предыдущая",
                    "next": "Следующая",
                    "last": "Последняя"
                },
                "aria": {
                    "sortAscending": ": активировать для сортировки столбца по возрастанию",
                    "sortDescending": ": активировать для сортировки столбца по убыванию"
                }

            },
            pagingType: 'simple',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('roles.list') }}",
            columns: [
                {
                    data: 'id',
                    name: 'r.id'
                },
                {
                    data: 'name',
                    name: 'r.name'
                },
                {
                    data: 'guard_name',
                    name: 'r.guard_name'
                },
                {
                    data: 'created_at',
                    name: 'r.created_at'
                },
                {
                    data: 'updated_at',
                    name: 'r.updated_at'
                },
                {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
