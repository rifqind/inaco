<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
        Add Another Language
        [@foreach ($titles as $t)
        {{ $t }}
        @endforeach]
        :
        @else
        Create Banner
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
                <form class="form-validate" id="create-banner" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($data->banner_id)
                    <input type="hidden" value="{{ $data->banner_id }}" name="banner_id">
                    @endif
                    <div class="form-group row {{ $data->banner_name ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="banner_name">Banner Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{$data->banner_name}}" id="banner_name" name="banner_name"
                                placeholder="Enter Banner Name">
                            <div class="invalid-feedback">Please enter banner name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="banner_caption">Banner Caption <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="banner_caption" rows="5" placeholder="Enter Caption." class="form-control"></textarea>
                            <div class="invalid-feedback">Please enter the caption</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
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
                    @if ($data->banner_image)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="">Banner Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="hidden" value="{{ $data->banner_image }}" class="form-control-file"
                                id="banner_image" name="banner_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Banner Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" style="width:200px;" class="form-control-file" id="banner_image"
                                name="banner_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row {{ $data->banner_status ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Banner Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="banner_status" id="banner_status1"
                                    value="1" {{ $data->banner_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="banner_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="banner_status" id="banner_status2"
                                    value="0" {{ $data->banner_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="banner_status2">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="banner_url">Banner URL<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="banner_url" name="banner_url"
                                placeholder="Enter Url">
                            <div class="invalid-feedback">Please enter banner name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Banner List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-homebanner.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>