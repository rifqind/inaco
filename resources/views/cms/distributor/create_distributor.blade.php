<x-app-layout>
    <x-slot name="breadcrumb">
        Create Distributor
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-distributor" action="" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="distributor_name">Distributor Name<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="distributor_name" name="distributor_name"
                                placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="phone">Phone<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter Phone">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="country">Select Country<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="country" name="country"
                                style="width:200px;">
                                <option value="" disabled selected>Please select</option>
                                @foreach ($country as $value)
                                    <option value="{{ $value->value }}">
                                        {{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="province">Select Province</label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="province" name="province"
                                style="width:200px;">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="city">Select City</label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="city" name="city"
                                style="width:200px;">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="district">Select District</label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="district" name="district"
                                style="width:200px;">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="subdistrict">Select Subdistrict</label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="subdistrict" name="subdistrict"
                                style="width:200px;">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="address">Address<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <textarea class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="latitude">Latitude<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                placeholder="Enter Latitude">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="longitude">Longitude<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Enter Longitude">
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
