<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($routeName == 'social-media.list')
            Official Social Media
        @elseif ($routeName == 'marketplace.list')
            Official Marketplace
        @endif
    </x-slot>
    <x-slot name="head">
        <!-- DataTables css -->
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <!-- Responsive Datatable css -->
        <style type="text/css">
            .overflow-x-scroll {
                overflow-x: scroll;
            }
        </style>
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header pt-0">
                <div class="d-sm-flex justify-content-between">
                    <a href="{{ route('socmed-marketplace.create') }}" class="btn btn-primary-rgba position-absolute"><i
                            class="feather icon-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="overflow-x-scroll">
                    @if ($routeName == 'socmed-marketplace.social-media.list')
                        <table id="datatable-socmed" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Instagram</th>
                                    <th>Facebook</th>
                                    <th>Tiktok</th>
                                    <th>Youtube</th>
                                    <th>Twitter</th>
                                    <th>Linkedin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr data-id="{{ $value->id }}">
                                        <td>{{ $value->instagram }}</td>
                                        <td>{{ $value->facebook }}</td>
                                        <td>{{ $value->tiktok }}</td>
                                        <td>{{ $value->youtube }}</td>
                                        <td>{{ $value->twitter }}</td>
                                        <td>{{ $value->linkedin }}</td>
                                        <td><a href="{{ route('socmed-marketplace.update', ['id' => $value->id]) }}"
                                                class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="feather icon-edit"></i></a>
                                            <button type="button" class="btn btn-round btn-danger delete-row"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                data-id="{{ $value->id }}"><i class="feather icon-trash-2"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif ($routeName == 'socmed-marketplace.marketplace.list')
                        <table id="datatable-marketplace" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Shopee</th>
                                    <th>Tokopedia</th>
                                    <th>Lazada</th>
                                    <th>Tiktokshop</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr data-id="{{ $value->id }}">
                                        <td>{{ $value->shopee }}</td>
                                        <td>{{ $value->tokopedia }}</td>
                                        <td>{{ $value->lazada }}</td>
                                        <td>{{ $value->tiktokshop }}</td>
                                        <td><a href="{{ route('socmed-marketplace.update', ['id' => $value->id]) }}"
                                                class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="feather icon-edit"></i></a>
                                            <button type="button" class="btn btn-round btn-danger delete-row"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                data-id="{{ $value->id }}"><i class="feather icon-trash-2"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- Datatable js -->
        <script src="{{ asset('assets/js/custom/custom-socmed-market.js')}}"></script>
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
        <!-- <script src="{{ asset('assets/js/custom/custom-table-datatable.js') }}"></script> -->
    </x-slot>
</x-app-layout>