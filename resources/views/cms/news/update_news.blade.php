<x-app-layout>
    <x-slot name="breadcrumb">
        Update News : {{ $data->news_title }}
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
                <form class="form-validate" id="create-news" action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="news_translation_id">
                    <input type="hidden" value="{{ $data->news_id }}" name="news_id">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="news_category">Category<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="news_category" name="news_category" style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                <option value="1" {{ $data->news_category == 1 ? 'selected' : '' }}>Article</option>
                                <option value="2" {{ $data->news_category == 2 ? 'selected' : '' }}>Press Release
                                </option>
                            </select>
                            <div class="invalid-feedback">Please select a category</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="news_title">Title<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->news_title }}" class="form-control" id="news_title"
                                name="news_title" placeholder="Enter Title">
                            <div class="invalid-feedback">Please enter the title</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="news_description">Content Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="news_description" rows="5" placeholder="Enter Content." class="form-control">
                                {{ $data->news_description }}
                            </textarea>
                            <div class="invalid-feedback">Please enter the content</div>
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
                            <div class="invalid-feedback">Please select a language</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val_image">Create Date</label>
                        <div class="col-lg-6">
                            <div class="input-group" style="width:200px;">
                                <input type="text" name="create_date_update" id="autoclose-date"
                                    class="datepicker-here form-control" placeholder="dd/mm/yyyy"
                                    aria-describedby="basic-addon3" />
                                <div class="input-group-append">
                                    <label for="autoclose-date" class="input-group-text" id="basic-addon3"><i
                                            class="feather icon-calendar"></i></label>
                                </div>
                            </div>
                            <div class="">Please select an updated date</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">News Image</label>
                        <div class="col-lg-6">
                            <input type="file" class="form-control-file" id="news_image_update"
                                name="news_image_update">
                            <div class="">Please select an updated image if exists</div>
                            <div>Minimum Dimension : 526 x 307</div>
                            <div>Max Size : 200kb (.png)</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">News Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="news_status" id="news_status1"
                                    value="1" {{ $data->news_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="news_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="news_status" id="news_status2"
                                    value="0" {{ $data->news_status == 0 ? 'checked' : '' }}>
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
                <div id="back" type="button" class="btn btn-success">Back to News List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-news.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <!-- Datepicker JS -->
        <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-datepicker.js') }}"></script>

        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>
