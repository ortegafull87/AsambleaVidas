<!-- Profile Image -->
<div class="box box-primary">
    <div class="box-body box-profile">
        <div class="image-box-container">
            <img id="image_profile" class="profile-user-img img-responsive img-circle"
                 src="{{ asset('').env('URL_BASE_IMGS').((empty($user->image))?'no-image-profile.png':$user->image)}}"
                 alt="User profile picture">
            <div class="btn-update-image">
                <span class="fa fa-pencil"></span>
            </div>
        </div>
        <h3 class="profile-username text-center">{{$user->name}}</h3>

        <p class="text-muted text-center">Miembro desde: @include('comun.merbersince')</p>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Aportes</b> <a class="pull-right">{{$score['contributions']}}</a>
            </li>
            <li class="list-group-item">
                <b>Comentarios</b> <a class="pull-right">{{$score['comments']}}</a>
            </li>
            <li class="list-group-item">
                <b>Favoritos</b> <a class="pull-right">{{$score['favorites']}}</a>
            </li>
        </ul>

        <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->