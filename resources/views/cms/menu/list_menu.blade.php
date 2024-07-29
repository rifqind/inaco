<x-app-layout>
    <x-slot name="breadcrumb">
        Menu Navigation
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-header pt-0">
                <div class="d-sm-flex justify-content-between">
                    <a href="{{route('menu.create')}}" class="btn btn-primary-rgba position-absolute"><i class="feather icon-plus mr-2"></i>Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table id="datatable-menu" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Parent Menu</th>
                                <th>Menu</th>
                                <th>Category</th>
                                <th>On Website</th>
                                <th>Lang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                            <tr data-id="{{ $value->id }}">
                                <td>{{ $value->parent_title }}</td>
                                <td>{{ $value->menu_title }}</td>
                                <td>
                                    @if ($value->menu_category == 1)
                                    Pages
                                    @elseif ($value->menu_category == 2)
                                    News
                                    @elseif ($value->menu_category == 3)
                                    Products
                                    @else
                                    Unknown
                                    @endif
                                </td>
                                <td>
                                    @if ($value->on_website == 1)
                                    Yes
                                    @else
                                    No
                                    @endif
                                </td>
                                <td>{{ $value->language_name }}</td>
                                <td><a href=" {{ route('menu.update', ['id' => $value->id]) }} " class="btn btn-round btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="feather icon-edit"></i></a>
                                    <button type="button" class="btn btn-round btn-danger delete-row" data-toggle="tooltip" data-placement="top" title="Delete" data-id="5"><i class="feather icon-trash-2"></i></button>
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
    </x-slot>
</x-app-layout>