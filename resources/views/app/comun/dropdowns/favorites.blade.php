<li class="dropdown messages-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Audios favoritos">
        <i class="fa fa-heart-o"></i>
        <span class="label label-danger">
            @if(count($favorites) > 9)
                +9
            @else
                {{count($favorites)}}
            @endif
        </span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">Tienes {{count($favorites)}} audios favoritos</li>
        <li>
            <!-- inner menu: contains the messages -->
            <ul class="menu">
                @include('app.comun.dropdowns.favorites-item')
            </ul>
            <!-- /.Lista -->
        </li>
        <li class="footer"><a href="#">See All Messages</a></li>
    </ul>
</li>
<!-- /.messages-menu -->