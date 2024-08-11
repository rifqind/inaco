<x-app-layout>
    <x-slot name="breadcrumb">
        @if ($data->language_code)
            Add Another Language
            [@foreach ($titles as $t)
                {{ $t }}
            @endforeach]
            :
        @else
            Create Menu Navigation
        @endif
    </x-slot>
    <x-slot name="head"></x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" action="{{ route('menu.store') }}" method="post">
                    @csrf
                    <!-- {{ $data }} -->
                    @if ($data->menu_id)
                        <input type="hidden" value="{{ $data->menu_id }}" name="menu_id">
                    @endif
                    <div class="form-group row {{ $data->parent_check ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="parent_menu">Parent Menu<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="parent_menu" name="parent_menu" style="width:200px;">
                                <option value="0" {{ $data->parent_menu == 0 ? 'selected' : '' }}>As Parent
                                </option>
                                @foreach ($parent as $value)
                                    <option value="{{ $value->value }}"
                                        {{ $data->parent_menu == $value->value ? 'selected' : '' }}>
                                        {{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu-title">Menu Title<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu-title" name="menu_title"
                                placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->menu_category ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="menu_category">Menu Category<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="menu_category" name="menu_category" style="width:200px;">
                                <option value="" disabled>Please Select</option>
                                <option value="1" {{ $data->menu_category == 1 ? 'selected' : '' }}>Pages
                                </option>
                                <option value="2" {{ $data->menu_category == 2 ? 'selected' : '' }}>News
                                </option>
                                <option value="3" {{ $data->menu_category == 3 ? 'selected' : '' }}>Products
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row {{ $data->on_website ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="val-phoneus">Display on Website<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="on_website" id="on_website1"
                                    value="1" {{ $data->on_website == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="on_website1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="on_website" id="on_website2"
                                    value="0" {{ $data->on_website == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="on_website2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu_web_url">URL Website<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu_web_url" name="menu_web_url"
                                placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="menu_cms_url">URL CMS<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="menu_cms_url" name="menu_cms_url"
                                placeholder="Enter URL">
                        </div>
                    </div>
                    <div class="form-group row {{ $data->icon_on_cms ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="icon_on_cms">Icon on CMS<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->icon_on_cms ? $data->icon_on_cms : '' }}"
                                class="form-control" id="icon_on_cms" name="icon_on_cms"
                                placeholder="Enter Script Icon">
                        </div>
                        <div class="col-lg-1  col-form-label"><a href="#" data-toggle="modal"
                                data-target=".bd-example-modal-lg" title="INFO ICON"><i
                                    class="feather icon-info"></i></a></div>
                        @include('cms.layouts.icon')
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="language_code">Language<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="language_code" name="language_code"
                                style="width:200px;">
                                <option value="" disabled selected>Please select</option>
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
                        </div>
                    </div>
                    <div class="form-group row {{ $data->display_sequence ? 'd-none' : '' }}">
                        <label class="col-lg-3 col-form-label" for="display_sequence">Display Sequence<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control" id="display_sequence" name="display_sequence"
                                style="width:200px;">
                                <option value="">Please select</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}"
                                        {{ $data->display_sequence == $i ? 'selected' : '' }}>{{ $i }}
                                    </option>
                                @endfor
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
                <div id="back" type="button" class="btn btn-success">Back to Menu Navigation List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-menu-form.js') }}"></script>
    </x-slot>
</x-app-layout>
