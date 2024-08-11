<x-app-layout>
    <x-slot name="breadcrumb">
        Update Social Media & Marketplace
    </x-slot>
    <x-slot name="head"></x-slot>
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body">
                <!-- h6 class="card-subtitle">Basic form validation.</h6 -->
                <form class="form-validate" action="/menu/update" method="post">
                    @csrf
                    <input id="data-id" name="id" type="hidden" value="{{ $data->id }}">
                    <h4 class="m-b-30">Social Media</h4>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="instagram">Instagram Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->instagram }}" class="form-control" id="instagram"
                                name="instagram" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="facebook">Facebook Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->facebook }}" class="form-control" id="facebook"
                                name="facebook" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tiktok">Tiktok Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->tiktok }}" class="form-control" id="tiktok"
                                name="tiktok" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="youtube">Youtube Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->youtube }}" class="form-control" id="youtube"
                                name="youtube" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row m-b-30">
                        <label class="col-lg-3 col-form-label" for="twitter">Twitter Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->twitter }}" class="form-control" id="twitter"
                                name="twitter" placeholder="Enter Link">
                        </div>
                    </div>
                    <h4 class="m-b-30">Marketplace</h4>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="shopee">Shopee Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->shopee }}" class="form-control" id="shopee"
                                name="shopee" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tokopedia">Tokopedia Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->tokopedia }}" class="form-control" id="tokopedia"
                                name="tokopedia" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="lazada">Lazada Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->lazada }}" class="form-control" id="lazada"
                                name="lazada" placeholder="Enter Link">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="tiktokshop">Tiktokshop Link<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="text" value="{{ $data->tiktokshop }}" class="form-control"
                                id="tiktokshop" name="tiktokshop" placeholder="Enter Link">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"></label>
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                        </div>
                    </div>
                </form>
                <div id="back-socmed" type="button" class="btn btn-success m-r-10">Back to Social Media</div>
                <div id="back-marketplace" type="button" class="btn btn-info">Back to Marketplace</div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script src="{{ asset('assets/js/custom/custom-socmed-market.js') }}"></script>
    </x-slot>
</x-app-layout>
