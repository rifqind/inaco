<x-app-layout>
    <x-slot name="breadcrumb">
        Pages
    </x-slot>
    <x-slot name="head">
        <!-- DataTables css -->
        <link href="{{ secure_asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ secure_asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive Datatable css -->
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header pt-0">
                @if (!$is_slugged)
                <div class="d-sm-flex justify-content-between">
                    <a href="{{ route('pages.create') }}" class="btn btn-primary-rgba position-absolute"><i class="feather icon-plus mr-2"></i>Add New</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="">
                    <table id="datatable-pages" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Lang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                            <tr data-id="{{ $value->id }}">
                                <td>{{ $value->pages_title }}</td>
                                <td>{{ $value->pages_description }}</td>
                                <td>{{ $value->language_name }}</td>
                                <td>
                                    @if (!$is_slugged)
                                    <a href="{{ route('pages.update', ['id' => $value->id]) }}" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                    <a href="{{ route('pages.create') }}?pages_id={{ $value->pages_id }}&language_code={{ $value->languageList }}" class="btn btn-round btn-info" data-toggle="tooltip" data-placement="top" title="Add Language"><i class="ion ion-ios-add-circle-outline text-white"></i></a>
                                    <button type="button" class="btn btn-round btn-danger delete-row" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $value->id }}"><i class="feather icon-trash-2"></i></button>
                                    @else
                                    <a href="{{ route('pages.update', ['id' => $value->id]) }}?is_slugged={{ $pages_slug }}"
                                        class="btn btn-round btn-success"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                    <a href="{{ route('pages.create') }}?pages_id={{ $value->pages_id }}&language_code={{ $value->languageList }}&is_slugged={{ $pages_slug }}"
                                        class="btn btn-round btn-info"
                                        data-toggle="tooltip" data-placement="top" title="Add Language"><i class="ion ion-ios-add-circle-outline text-white"></i></a>
                                    @endif
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
        <script type="text/javascript">sessionStorage.clear();
      //  sessionStorage.setItem("url_listpage", window.location.href);
    //alert(sessionStorage.getItem("url_listpage"));</script>
        <script src="{{ secure_asset('assets/js/custom/custom-page.js')}}?v=<?php echo rand(); ?>"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ secure_asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    </x-slot>
</x-app-layout>