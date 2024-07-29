<x-app-layout>
    <x-slot name="breadcrumb">
        Create Menu Navigation
    </x-slot>
    <x-slot name="head"></x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" action="{{ route('menu.store') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="parent_menu">Parent Menu<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="parent_menu" name="parent_menu" style="width:200px;">
                                <option value="0">As Parent</option>
                                @foreach ($parent as $value)
                                <option value="{{$value->value}}">{{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu-title">Menu Title<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu-title" name="menu_title" placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu_category">Menu Category<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="menu_category" name="menu_category" style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                <option value="1">Pages</option>
                                <option value="2">News</option>
                                <option value="3">Products</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Display on Website<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="on_website" id="on_website1" value="1" checked>
                                <label class="form-check-label" for="on_website1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="on_website" id="on_website2" value="0">
                                <label class="form-check-label" for="on_website2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu_web_url">URL Website<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu_web_url" name="menu_web_url" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu_cms_url">URL CMS<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu_cms_url" name="menu_cms_url" placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="icon_on_cms">Icon on CMS<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="icon_on_cms" name="icon_on_cms" placeholder="Enter Script Icon">
                        </div>
                        <div class="col-lg-1  col-form-label"><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" title="INFO ICON"><i class="feather icon-info"></i></a></div>
                        @include('cms.layouts.icon')
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code" style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($languages as $value)
                                <option value="{{$value->value}}">{{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="display_sequence">Display Sequence<span class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="display_sequence" name="display_sequence" style="width:200px;">
                                <option value="">Please select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
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
        <div id="back" type="button" class="btn btn-success">Kembali</div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-menu-form.js')}}"></script>
    </x-slot>
</x-app-layout>