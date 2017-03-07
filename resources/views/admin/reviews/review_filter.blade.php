<div class="box box-primary">
    <div class="box-header with-border">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa  fa-filter" aria-hidden="true"></i></div>
            <input id="finder_track" type="text" name="finderTrack" class="form-control" data-url="{{asset('admin/review/:id/track')}}" placeholder="Buscar...">
        </div>
    </div>
    <div class="box-body"><!-- /.box-header -->
        <ul class="products-list product-list-in-box">
            @foreach($filters as $filter)
                <li class="item"><!-- /.item -->
                    <div class="product-info">
                        <a href="{{asset('admin/review/'.$filter['id'].'/tracks')}}" class="product-title">
                            <span class="{{$filter['icon']}}"></span> {{$filter['genre']}}
                            <span id="pd_{{$filter['id']}}"
                                  class="label label-info pull-right">{{$filter['count']}}</span>
                        </a>
                    <span class="product-description">
                        {{$filter['description']}}
                    </span>
                    </div>
                </li><!-- /.item -->
            @endforeach
        </ul>
    </div>
    <!-- /.box-body -->
    <!--<div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase">View All Products</a>
    </div>-->
    <!-- /.box-footer -->
</div>