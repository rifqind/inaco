<x-app-layout>
    <x-slot name="breadcrumb">
        Update International Market
    </x-slot>
    <x-slot name="head">
    </x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" id="create-intermarket" action="" method="post">
                    @csrf
                    <input type="hidden" name="market_id" value="{{$data->market_id}}" />
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="country">Select Country<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="country" name="country"
                                style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                @foreach ($country as $value)
                                <option value="{{ $value->value }}" {{ $data->country == $value->value ? 'selected' : ''}}>{{ $value->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="product_export">Select Product<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <select class="form-control select2-single" id="product_export" name="product_export"
                                style="width:200px;">
                                <option value="" disabled selected>Please Select</option>
                                <option value="0">Semua Produk</option>
                                @foreach ($product as $value)
                                <option value="{{ $value->value }}" {{ $data->product_export == $value->value ? 'selected' : '' }}>{{ $value->label }}</option>
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
                <div id="back" type="button" class="btn btn-success">Back to International Market List</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
        <script src="{{ asset('assets/js/custom/custom-intermarket.js') }}"></script>
    </x-slot>
</x-app-layout>