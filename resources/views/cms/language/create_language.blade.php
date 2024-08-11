<x-app-layout>
    <x-slot name="breadcrumb">
        Create Language
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-language" action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="code">Code<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Enter Language Code (Max 2 Char)">
                            <div class="invalid-feedback">Please enter language code</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="name">Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Language Name">
                            <div class="invalid-feedback">Please enter language name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Icon Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" style="width:200px;" class="form-control-file" id="icon_image"
                                name="icon_image">
                            <div class="invalid-feedback">Please select an image</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Language List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-language.js') }}"></script>
    </x-slot>
</x-app-layout>
