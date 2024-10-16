<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
            Add Another Language
            [@foreach ($titles as $t)
                {{ $t }}
            @endforeach]
            :
        @else
            Create Sub Pages
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
                <form class="form-validate" id="create-subpage" action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- {{ $data }} -->
                    @if ($data->sub_pages_id)
                        <input type="hidden" value="{{ $data->sub_pages_id }}" name="sub_pages_id">
                    @endif
                    <div class="form-group row {{ $data->pages_id ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="pages_id">Page<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="select2-single form-control" id="pages_id" name="pages_id"
                                style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @if ($data->pages_id)
                                    @foreach ($pages as $value)
                                        <option value="{{ $value->value }}"
                                            {{ $data->pages_id == $value->value ? 'selected' : '' }}>{{ $value->label }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($pages as $value)
                                        <option value="{{ $value->value }}">{{ $value->label }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">Please select the page</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="sub_pages_title">Title<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="sub_pages_title" name="sub_pages_title"
                                placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="sub_pages_description">Content Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="sub_pages_description" rows="5" placeholder="Enter Content." class="form-control"></textarea>
                            <div class="invalid-feedback">Please enter the content</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($languages as $value)
                                    @if ($data->language_code)
                                        <option value="{{ $value->value }}"
                                            {{ in_array($value->value, $data->language_code->toArray()) ? 'hidden' : '' }}>
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
                    @if ($data->sub_pages_image)
                        <div class="form-group row d-none">
                            <label class="col-lg-3 col-form-label" for="sub_pages_image">Sub Page Image<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="hidden" class="form-control-file" value="{{ $data->sub_pages_image }}"
                                    id="sub_pages_image" name="sub_pages_image">
                                <div class="invalid-feedback">Please select an image</div>
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="sub_pages_image">Sub Page Image<span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="file" style="width:200px;" class="form-control-file"
                                    id="sub_pages_image" name="sub_pages_image">
                                <div class="invalid-feedback">Please select an image</div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row {{ $data->sub_pages_status ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Sub Page Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sub_pages_status"
                                    id="sub_pages_status1" value="1"
                                    {{ $data->sub_pages_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="sub_pages_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sub_pages_status"
                                    id="sub_pages_status2" value="0"
                                    {{ $data->sub_pages_status == 0 ? 'checked' : '' }}>
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
                <div id="back" type="button" class="btn btn-success">Back to Sub Pages List</div>
            </div>
        </div>
    </div>
    <div class="d-none is-slugged">{{ $is_slugged }}</div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-subpage.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>
