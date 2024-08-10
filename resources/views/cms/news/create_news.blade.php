<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
        Add Another Language
        [@foreach ($titles as $t)
        {{ $t }}
        @endforeach]
        :
        @else
        Create News
        @endif
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

        <!-- Datepicker css -->
        <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-news" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- {{ $data }} -->
                    @if ($data->news_id)
                    <input type="hidden" value="{{ $data->news_id }}" name="news_id">
                    @endif
                    <div class="form-group row {{ $data->news_category ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="news_category">Category<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="news_category" name="news_category" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                <option value="1" {{ $data->news_category==1 ? 'selected' : '' }}>Article</option>
                                <option value="2" {{ $data->news_category==2 ? 'selected' : '' }}>Press Release</option>
                            </select>
                            <div class="invalid-feedback">Please select a category</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="news_title">Title<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="news_title" name="news_title" placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="news_description">Content Description <span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="news_description" rows="5" placeholder="Enter Content." class="form-control"></textarea>
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
                    @if ($data->create_date)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="val_image">Create Date<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group" style="width:200px;">
                                <input type="text" name="create_date" value="{{ $data->create_date ? $data->create_date : '' }}" id="data-hidden" class="form-control" placeholder="dd/mm/yyyy" />
                                <div class="input-group-append">
                                    <label for="autoclose-date" class="input-group-text" id="basic-addon3"><i class="feather icon-calendar"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val_image">Create Date<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group" style="width:200px;">
                                <input type="text" name="create_date" id="autoclose-date" class="datepicker-here form-control" placeholder="dd/mm/yyyy" aria-describedby="basic-addon3" />
                                <div class="input-group-append">
                                    <label for="autoclose-date" class="input-group-text" id="basic-addon3"><i class="feather icon-calendar"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($data->news_image)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="">News Image<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="hidden" value="{{ $data->news_image }}" class="form-control-file" id="news_image" name="news_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">News Image<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" style="width:200px;" class="form-control-file" id="news_image" name="news_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row {{ $data->news_status ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">News Status<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="news_status" id="news_status1" value="1" {{ $data->news_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="news_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="news_status" id="news_status2" value="0" {{ $data->news_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="news_status2">Inactive</label>
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
        <div id="back" type="button" class="btn btn-success">Back to News List</div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-news.js')}}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <!-- Datepicker JS -->
        <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-datepicker.js') }}"></script>

        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>