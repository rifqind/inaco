<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
        Add Another Language
        [@foreach ($titles as $t)
        {{ $t }}
        @endforeach]
        :
        @else
        Create Pages
        @endif
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
                    {{ $data }}
                    @if ($data->pages_id)
                    <input type="hidden" value="{{ $data->pages_id }}" name="pages_id">
                    @endif
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_title">Title<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="pages_title" name="pages_title" placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="pages_description">Content Description <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="pages_description" rows="5" placeholder="Enter Content." class="form-control"></textarea>
                            <div class="invalid-feedback">Please enter the content</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($languages as $value)
                                @if ($data->language_code)
                                <option value="{{ $value->value }}" {{ in_array($value->value, $data->language_code->toArray()) ? 'hidden' : '' }}>
                                    {{ $value->label }}
                                </option>
                                @else
                                <option value="{{ $value->value }}">
                                    {{ $value->label }}
                                </option>    
                                @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    @if ($data->pages_image)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="">Page Image<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="hidden" value="{{ $data->pages_image }}" class="form-control-file" id="pages_image" name="pages_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Page Image<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control-file" id="pages_image" name="pages_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row {{ $data->pages_status ? 'd-none' : '' }}">
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