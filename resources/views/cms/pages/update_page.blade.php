<x-app-layout>
    <x-slot name="breadcrumb">
        Update Pages : {{ $data->pages_title }}
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-page" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input id="data-id" name="pages_translation_id" type="hidden" value="{{ $data->id }}">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_title">Title<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->pages_title }}" class="form-control" id="pages_title" name="pages_title" placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_description">Content Description <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" value="pages_description" name="pages_description" rows="5" placeholder="Enter Content." class="form-control">
                                {{ $data->pages_description }}
                            </textarea>
                            <div class="invalid-feedback">Please enter the content</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($languages as $value)
                                <option value="{{$value->value}}" {{ $data->language_code == $value->value ? 'selected' : '' }}>{{ $value->label }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_image">Page Image</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control-file" id="pages_image" name="pages_image_update">
                            <div class="">Please select an updated image if exists</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Page Status<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pages_status" id="pages_status1" value="1" {{ $data->pages_status == 1 ? 'checked' : '' }} >
                                <label class="form-check-label" for="pages_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pages_status" id="pages_status2" value="0" {{ $data->pages_status == 0 ? 'checked' : '' }} >
                                <label class="form-check-label" for="pages_status2">Inactive</label>
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
        <div id="back" type="button" class="btn btn-success">Back to Pages List</div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-page.js')}}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>