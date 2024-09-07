<!DOCTYPE html>
<html lang="{{$code}}" dir="{{$code == 'ar' ? 'rtl' : ''}}">
@include('web.layouts.head')
{{ $head }}

<body>
    @include('web.layouts.header')

    {{ $slot }}

    @include('web.layouts.footer')
    @include('web.layouts.script')
    {{ $script }}
    <!-- Start js -->
    <!-- End js -->
</body>

</html>