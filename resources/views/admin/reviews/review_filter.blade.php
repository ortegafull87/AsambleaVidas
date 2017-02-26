<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Filtros</h3>
    </div>
    <div class="box-body"><!-- /.box-header -->
        <ul class="products-list product-list-in-box">
            @foreach($filters as $filter)
            <li class="item"><!-- /.item -->
                <div class="product-info">
                    <a href="{{asset('admin/review/'.$filter['id'].'/tracks')}}" class="product-title">
                        <span class="{{$filter['icon']}}"></span> {{$filter['genre']}}
                        <span class="label label-info pull-right">{{$filter['count']}}</span>
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
    <div class="box-footer text-center">
        <a href="javascript:void(0)" class="uppercase">View All Products</a>
    </div>
    <!-- /.box-footer -->
</div>