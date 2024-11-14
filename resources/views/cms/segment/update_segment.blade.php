<x-app-layout>
    <x-slot name="breadcrumb">
        Update Segment
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
                    <input type="hidden" name="segment_id" value="{{ $data->segment_id }}" />
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="segment_name">Segment Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="segment_name" name="segment_name"
                                placeholder="Enter Segment Name" value="{{ $data->segment_name }}">
                            <div class="invalid-feedback">Please enter segment name</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="segment_name_non_id">Segment Name Non Id <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="segment_name_non_id" name="segment_name_non_id"
                                placeholder="Enter Segment Name Non Id" value="{{ $data->segment_name_non_id }}">
                            <div class="invalid-feedback">Please enter segment name</div>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Banner Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="file" style="width:200px;" class="form-control-file" id="banner_image"
                                name="banner_image">
                            <div>Minimum Dimension : 545 x 307</div>
                            <div>Max Size : 400kb (.png)</div>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="segment_description">Segment Description<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="segment_description" name="segment_description"
                                placeholder="Enter segment description" value="{{ $data->segment_description }}">
                            <div class="invalid-feedback">Please enter segment description</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Segment List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/segment.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>