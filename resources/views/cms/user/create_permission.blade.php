<x-app-layout>
    <x-slot name="breadcrumb">
        Create Permissions
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-permission" action="" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="permission_name">Select Available Permission<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="permission_name" name="permission_name"
                                style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                @foreach ($menu as $value)
                                <option value="{{ $value->menu_title }}">{{ $value->menu_title }}</option>
                                @endforeach
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
                <div id="back" type="button" class="btn btn-success">Back to Permission List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
        <script src="{{ asset('assets/js/custom/custom-permission.js') }}"></script>
    </x-slot>
</x-app-layout>