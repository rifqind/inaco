<x-app-layout>
    <x-slot name="breadcrumb">
        Product List
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
                <div class="category-filter d-flex align-items-center" id="filter-wrapper">
                    <label class="mr-2 mb-0">Filter Category :</label>
                    <select id="categoryFilter" class="form-control form-control-sm" style="width:200px">
                        <option value="">Show All</option>
                        @foreach ($category as $value)
                        <option value="{{ $value->category_title }}">{{ $value->category_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-sm-flex justify-content-between">
                    <a href="{{route('products.create')}}" class="btn btn-primary-rgba position-absolute"><i class="feather icon-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table id="datatable-products" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Segment</th>
                                <th>Lang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                            <tr data-id="{{ $value->id }}">
                                <td><img src="{{ asset('data/product/') }}/{{ $value->product_id }}/{{ $value->image }}" class="rounded mx-auto d-block image-list"></td>
                                <td>{{ $value->product_title }}</td>
                                <td>{{ $value->category_title }}</td>
                                <td>{{ $value->segment_name }}</td>
                                <td>{{ $value->language_name }}</td>
                                <td>
                                    <a href="{{ route('products.update', ['id' => $value->product_translation_id]) }}" class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                    <a href="{{ route('products.create') }}?product_id={{ $value->product_id }}&language_code={{ $value->languageList }}" class="btn btn-round btn-info" data-toggle="tooltip" data-placement="top" title="Add Language"><i class="ion ion-ios-add-circle-outline text-white"></i></a>
                                    <button type="button" class="btn btn-round btn-danger delete-row" data-toggle="tooltip" data-placement="top" title="Delete" data-id="{{ $value->product_translation_id }}"><i class="feather icon-trash-2"></i></button>
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
        <script src="{{ asset('assets/js/custom/custom-product.js')}}"></script>
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
        <script src="{{ asset('assets/js/custom/custom-table-datatable.js') }}"></script>
    </x-slot>
</x-app-layout>