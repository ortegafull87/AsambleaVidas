@extends('layouts.admin')

@section('htmlheader_title')
    Track | ADM
@endsection

@section('contentheader_title')
    Revista.
@endsection

@section('dinamic_head_content')
    <link href="{{ asset('/plugins/bootcomplete/bootcomplete.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('contentheader_description')
    Revisión de contenido
@endsection

@section('heather_level')
    <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Administrador</a></li>
    <li class="active"><i class="fa fa-music"></i> Revista</li>
@endsection

@section('main-content')
    <style>
        .products-list .product-info {
            margin-left: 5px;
        }

        .products-list .product-info span {
            margin-right: 5px;
        }
    </style>
    <div class="row">
        <div class="col-md-3">
            @include('admin.reviews.review_filter')
        </div>
        <div class="col-md-9">
            @include('admin.reviews.review_track')
        </div>
    </div>
@endsection
@section('view.scripts')
    <script src="{{ asset('/plugins/bootcomplete/jquery.bootcomplete.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/admin/Review.js') }}" type="text/javascript"></script>
@endsection