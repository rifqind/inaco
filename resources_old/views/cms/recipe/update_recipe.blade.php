<x-app-layout>
    <x-slot name="breadcrumb">
        Update Recipe :
    </x-slot>
    <x-slot name="head">
        <!-- Summernote css -->
        <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-recipe" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->recipe_id }}" name="recipe_id">
                    <input type="hidden" value="{{ $data->recipe_translation_id }}" name="recipe_translation_id">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_title">Recipe Title<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->recipe_title }}" id="recipe_title"
                                name="recipe_title" placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_description">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="summernote" name="recipe_description" rows="5"
                                placeholder="Enter Content.">
                            {{ $data->recipe_description }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="ingredient">Ingredient <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="summernote" name="ingredient" rows="5" placeholder="Enter Content.">
                            {{ $data->ingredient }}
                            </textarea>
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
                        <label class="col-lg-3 col-form-label" for="product_id">Product<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="select2-single form-control" id="product_id" name="product_id"
                                style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($product as $value)
                                    <option value="{{ $value->product_id }}" {{ $data->product_id == $value->product_id ? 'selected' : '' }}>
                                        {{ $value->product_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Current Recipe Image</label>
                        <div class="col-lg-6">
                            @foreach ($image as $img)
                                <img class="img-show"
                                    src="{{ asset('data/recipe/') . '/' . $img->recipe_id . '/' . $img->image_filename }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Recipe Image</label>
                        <div class="col-lg-6">
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control-file w-auto" id="recipe_image_update"
                                    name="recipe_image_update[]">
                                <div class="">
                                    <button class="btn btn-success btn-round h2" id="addImage-update"
                                        type="button">+</button>
                                </div>
                            </div>
                            <div id="imageContainer"></div>
                            <div>Minimum Dimension : 658 x 307</div>
                            <div>Max Size : 150kb (.png)</div>
                            <div>Select updated image if exists, existing image will be deleted</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_status">Recipe Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recipe_status" id="recipe_status1"
                                    value="1" {{ $data->recipe_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="recipe_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recipe_status" id="recipe_status2"
                                    value="0" {{ $data->recipe_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="recipe_status2">In Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_yt_confirm">Youtube Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="row pl-3 mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recipe_yt_confirm" id="recipe_yt_confirm1"
                                        value="1" {{ ($data->recipe_yt) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="recipe_yt_confirm1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recipe_yt_confirm"
                                        id="recipe_yt_confirm2" value="0"
                                        {{ (!$data->recipe_yt) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="recipe_yt_confirm2">No</label>
                                </div>
                            </div>
                            <div class="row pl-3 d-none" id="youtube-link-input">
                                <input type="text" class="form-control" id="recipe_yt" name="recipe_yt"
                                    placeholder="Enter Youtube Link">
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
                <div id="back" type="button" class="btn btn-success">Back to Recipe List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-recipe-form.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>