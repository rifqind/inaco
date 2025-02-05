<x-app-layout>
    <x-slot name="breadcrumb">
        Update Product Category : {{ $data->category_title }}
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-products-category" action="#" method="post">
                    @csrf
                    <input type="hidden" name="category_translation_id" value="{{ $data->category_translation_id }}">
                    <input type="hidden" name="category_id" value="{{ $data->category_id }}">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="category_title">Category Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->category_title }}" class="form-control"
                                id="category_title" name="category_title" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="category_description">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="category_description" rows="5" placeholder="Enter Content.">
                            {{ $data->category_description }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="segment_id">Segment<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="segment_id" name="segment_id" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($segments as $value)
                                    <option value="{{ $value->value }}"
                                        {{ $data->segment_id == $value->value ? 'selected' : '' }}>{{ $value->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($languages as $value)
                                    <option value="{{ $value->value }}"
                                        {{ $data->language_code == $value->value ? 'selected' : '' }}>
                                        {{ $value->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Current Category Image</label>
                        <div class="col-lg-6">
                            <img class="img-show" src="{{ asset('data/product/category/') . '/' . $data->category_image }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Category Image</label>
                        <div class="col-lg-6">
                            <input style="width:200px;" type="file" class="form-control-file"
                                id="category_image_update" name="category_image_update">
                            <div class="">Please select an updated image if exists</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="category_status">Category Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category_status"
                                    id="category_status1" value="1"
                                    {{ $data->category_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="category_status"
                                    id="icategory_status2" value="0"
                                    {{ $data->category_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_status2">In Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Product Category List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-product-category.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>
