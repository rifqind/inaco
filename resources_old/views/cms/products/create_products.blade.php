<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
        Add Another Language
        [@foreach ($titles as $t)
        {{ $t }}
        @endforeach]
        :
        @else
        Create Products
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
                <form class="form-validate" id="create-products" action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- {{ $data }} -->
                    @if ($data->product_id)
                    <input type="hidden" value="{{ $data->product_id }}" name="product_id">
                    @endif
                    <div class="form-group row {{ $data->category_id ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="category_id">Product Category<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="category_id" name="category_id" style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($categories as $value)
                                <option value="{{ $value->category_id }}"
                                    {{ $data->category_id == $value->category_id ? 'selected' : '' }}>
                                    {{ $value->category_title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="product_title">Product Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="product_title" name="product_title"
                                placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="product_description">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea id="summernote" name="product_description" rows="5" placeholder="Enter Content."></textarea>
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
                    <div class="form-group row {{ $data->product_url_tokopedia ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="product_url_tokopedia">URL Product on Tokopedia<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->product_url_tokopedia }}"
                                id="product_url_tokopedia" name="product_url_tokopedia" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->product_url_shopee ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="product_url_shopee">URL Product on Shopee<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->product_url_shopee }}"
                                id="product_url_shopee" name="product_url_shopee" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->product_url_lazada ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="product_url_lazada">URL Product on Lazada<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->product_url_lazada }}"
                                id="product_url_lazada" name="product_url_lazada" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->product_url_tiktokshop ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="product_url_tiktokshop">URL Product on
                            Tiktokshop<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->product_url_tiktokshop }}"
                                id="product_url_tiktokshop" name="product_url_tiktokshop" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->product_id ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="show_on_home1">Show on Homepage<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="show_on_home"
                                    id="show_on_home1" value="1"
                                    {{ $data->show_on_home == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_on_home1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="show_on_home"
                                    id="show_on_home2" value="0"
                                    {{ $data->show_on_home == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_on_home2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row {{ $data->display_sequence_onhome ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="display_sequence_onhome">Display Sequence<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="display_sequence_onhome" name="display_sequence_onhome"
                                style="width:200px;">
                                <option value="">Please select</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}"
                                    {{ $data->display_sequence_onhome == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    @if ($data->product_image)
                    <div class="form-group row d-none">
                        <label class="col-lg-3 col-form-label" for="">Product Images<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3 align-items-center">
                                <input type="hidden" value="{{ $data->product_image }}"
                                    class="form-control-file" id="product_image" name="product_image">
                                <div class="">
                                    <button class="btn btn-success btn-round h2" id="addImage"
                                        type="button">+</button>
                                </div>
                            </div>
                            <div id="imageContainer"></div>
                            <div>Minimum Dimension : 296 x 296</div>
                            <div>Max Size : 150kb (.png)</div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="">Product Images<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="input-group mb-3 align-items-center">
                                <input type="file" class="form-control-file w-auto" id="product_image"
                                name="product_image[]">
                                <div class="">
                                    <button class="btn btn-success btn-round h2" id="addImage"
                                    type="button">+</button>
                                </div>
                            </div>
                            <div id="imageContainer"></div>
                            <div>Minimum Dimension : 296 x 296</div>
                            <div>Max Size : 150kb (.png)</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row {{ $data->product_id ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="product_status">Product Status<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="product_status"
                                    id="product_status1" value="1"
                                    {{ $data->product_status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="product_status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="product_status"
                                    id="iproduct_status2" value="0"
                                    {{ $data->product_status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="product_status2">In Active</label>
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
                <div id="back" type="button" class="btn btn-success">Back to Product List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-product-form.js') }}"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
    </x-slot>
</x-app-layout>