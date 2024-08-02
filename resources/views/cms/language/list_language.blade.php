<x-app-layout>
    <x-slot name="breadcrumb">
        Languages
    </x-slot>
    <x-slot name="head">
        <!-- DataTables css -->
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive Datatable css -->
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header pt-0">
                <div class="d-sm-flex justify-content-between">
                    <a href="{{ route('language.create') }}" class="btn btn-primary-rgba position-absolute"><i class="feather icon-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table id="datatable-language" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Language</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                            <tr data-id="{{ $value->code }}">
                                <td><img src="{{ asset('data/language/') }}/{{ $value->icon_image }}" class="rounded mx-auto d-block image-list"></td>
                                <td>{{ $value->code }}</td>
                                <td>{{ $value->name }}</td>
                                <td><a href="{{ route('language.update', ['id' => $value->code]) }}" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                    <button type="button" class="btn btn-round btn-danger delete-row" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $value->code }}"><i class="feather icon-trash-2"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- Datatable js -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-language.js')}}"></script>
    </x-slot>
</x-app-layout>