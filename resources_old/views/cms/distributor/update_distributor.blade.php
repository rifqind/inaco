<x-app-layout>
    <x-slot name="breadcrumb">
        Update Distributor : {{ $data->distributor_name }}
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-distributor" action="" method="post">
                    @csrf
                    <input type="hidden" name="distributor_id" value="{{ $data->distributor_id }}" />
                    <input type="hidden" id="province-update" value="{{ $data->province }}" />
                    <input type="hidden" id="city-update" value="{{ $data->city }}" />
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="province">Select Province<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="province" name="province"
                                style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                @foreach ($province as $value)
                                <option value="{{ $value->value }}" {{ $data->province == $value->value ? 'selected' : '' }} data-code="{{ $value->code }}">{{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="city">Select City<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="city" name="city"
                                style="width:200px;">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="distributor_type">Distributor Type<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="distributor_type" id="distributor_type1"
                                    value="1" {{ $data->distributor_type == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="distributor_type1">Big City</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="distributor_type" id="distributor_type2"
                                    value="2" {{ $data->distributor_type == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="distributor_type2">Small City</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="distributor_name">Distributor Name</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" value="{{ $data->distributor_name }}" id="distributor_name" name="distributor_name"
                                placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back" type="button" class="btn btn-success">Back to Distributor List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="{{ asset('assets/js/custom/custom-distributor.js') }}"></script>
    </x-slot>
</x-app-layout>