<x-app-layout>
    <x-slot name="breadcrumb">
        Update Banner : {{ $data->banner_name }} ({{ $data->language_code }})
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
                    <input type="hidden" value="{{ $data->banner_id }}" name="banner_id">
                    <input type="hidden" value="{{ $data->banner_translation_id }}" name="banner_translation_id">
                    <div class="form-group row">
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
                            <textarea id="summernote" name="banner_caption" rows="5" placeholder="Enter Caption." class="form-control">{{$data->banner_caption}}</textarea>
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
                                <option value="{{ $value->value }}" {{ $data->language_code == $value->value ? 'selected' : '' }}>
                                    {{ $value->label }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Banner Image</label>
                        <div class="col-lg-6">
                            <input type="file" style="width:200px;" class="form-control-file" id="banner_image_update"
                                name="banner_image_update">
                            <div>Please select an updated image if exists</div>
                            <div>Minimum Dimension : 545 x 307</div>
                            <div>Max Size : 400kb</div>
                        </div>
                    </div>
                    <div class="form-group row">
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
                        <label class="col-lg-3 col-form-label" for="display_sequence">Display Sequence<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="display_sequence" name="display_sequence" style="width:200px;">
                                <option value="">Please select</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $data->display_sequence == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="banner_url">Banner URL<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{$data->banner_url}}" class="form-control" id="banner_url" name="banner_url"
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