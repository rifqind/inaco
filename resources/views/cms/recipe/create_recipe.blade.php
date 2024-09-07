<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
        Add Another Language
        [@foreach ($titles as $t)
        {{ $t }}
        @endforeach]
        :
        @else
        Create Recipe
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
                <form class="form-validate" id="create-recipe" action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- {{ $data }} -->
                    @if ($data->recipe_id)
                    <input type="hidden" value="{{ $data->recipe_id }}" name="recipe_id">
                    @endif
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_title">Recipe Title<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="recipe_title" name="recipe_title"
                                placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="recipe_description">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="summernote" name="recipe_description" rows="5" placeholder="Enter Content."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="ingredient">Ingredient <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="summernote" name="ingredient" rows="5" placeholder="Enter Content."></textarea>
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
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="product_id">Product<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="select2-single form-control" id="product_id" name="product_id"
                                style="width:200px;">
                                <option value="" selected disabled>Please select</option>
                                @foreach ($product as $value)
                                <option value="{{ $value->product_id }}">{{ $value->product_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if ($data->recipe_image)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="">Recipe Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3 align-items-center">
                                <input type="hidden" value="{{ $data->recipe_image }}" class="form-control-file"
                                    id="recipe_image" name="recipe_image">
                                <div>
                                    <button class="btn btn-success btn-round h2" id="addImage"
                                        type="button">+</button>
                                </div>
                            </div>
                            <div id="imageContainer"></div>
                            <div>Minimum Dimension : 658 x 307</div>
                            <div>Max Size : 150kb (.png)</div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Recipe Image<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3 align-items-center">
                                <input type="file" class="form-control-file w-auto" id="recipe_image"
                                    name="recipe_image[]">
                                <div class="">
                                    <button class="btn btn-success btn-round h2" id="addImage"
                                        type="button">+</button>
                                </div>
                            </div>
                            <div id="imageContainer"></div>
                            <div>Minimum Dimension : 658 x 307</div>
                            <div>Max Size : 150kb (.png)</div>

                        </div>
                    </div>
                    @endif
                    <div class="form-group row {{ $data->recipe_id ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="recipe_status">Recipe Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recipe_status" id="recipe_status1"
                                    value="1" {{ $data->recipe_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="recipe_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recipe_status"
                                    id="recipe_status2" value="0"
                                    {{ $data->recipe_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="recipe_status2">In Active</label>
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