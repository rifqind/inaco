<x-app-layout>
    <x-slot name="breadcrumb">
        Create Sub Pages
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-subpage" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_id">Page<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="select2-single form-control" id="pages_id" name="pages_id" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($pages as $value)
                                <option value="{{$value->value}}">{{ $value->label }}</option>                                    
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select the page</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="sub_pages_title">Title<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="sub_pages_title" name="sub_pages_title" placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="sub_pages_description">Content Description <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="sub_pages_description" rows="5" placeholder="Enter Content." class="form-control"></textarea>
                            <div class="invalid-feedback">Please enter the content</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($languages as $value)
                                <option value="{{$value->value}}">{{ $value->label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="sub_pages_image">Sub Page Image<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control-file" id="sub_pages_image" name="sub_pages_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Sub Page Status<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sub_pages_status" id="sub_pages_status1" value="1" checked>
                                <label class="form-check-label" for="sub_pages_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sub_pages_status" id="sub_pages_status2" value="0">
                                <label class="form-check-label" for="sub_pages_status2">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="back" type="button" class="btn btn-success">Back to Sub Pages List</div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-subpage.js')}}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>