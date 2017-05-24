@foreach($posts as $post)
    <div class="{{($post->post_track_parent_id > 0)?'replayed-post':''}}">
        <div class="user-block" id="{{$post->id}}">
            <img class="img-circle img-bordered-sm"
                 src="{{ asset('').env('URL_BASE_IMGS').((empty($post->image))?'no-image-profile.png':$post->image)}}"
                 alt="user image">
                        <span class="username">
                          <a href="#">{{$post->name}}</a>
                            <!--<a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>-->
                        </span>
            <span class="description">Publicado - {{\App\Library\Util::FORMAT_DATE_TO($post->created_at,'j F Y g:i a')}}</span>
        </div>
        <!-- /.user-block -->

        <p class="post-comment" data-id="{{$post->id}}">
            @if($post->updated_at >$post->created_at)
                @include('app.comun.pencil-post_updated')
            @endif
            {{$post->comment}}
        </p>
        <ul class="list-inline" data-id="{{$post->id}}">
            <li><a href="#" class="link-black text-sm" data-action="go-comment"><i class="fa fa-reply margin-r-5"></i>
                    Responder</a></li>
            @if(Auth::check() && ($post->user_id == Auth::User()->id))
                <li><a href="#" class="link-black text-sm" data-action="go-edit-comment"><i
                                class="ion-edit margin-r-5"></i>
                        Editar</a></li>
            @endif
        </ul>
        @if(Auth::check() && ($post->user_id == Auth::User()->id))
            <div class="edit-post well hidden" data-id="{{$post->id}}"
                 data-url="{{asset('estudios/audios/post/'.$post->id.'/updatePostTrack')}}">
                <textarea id="post_to_edit" class="form-control" data-autoresize>{{$post->comment}}</textarea>
                <button class="btn btn-default" data-action="cancel-edit-comment"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i>
                    Cancelar
                </button>
                <button class="btn btn-info" data-action="edit-comment"><i class="fa fa-check" aria-hidden="true"></i>
                    Editar
                </button>
            </div>
        @endif
        <div class="input-group input-group-md hidden">
            <input class="form-control input-sm " type="text"
                   placeholder="Presiona Enter cuando termines o el botón azul Responder" id="comment_post"
                   data-id="{{$post->id}}">
        <span class="input-group-addon bg-aqua c-pointer" id="btn_do_comment_post">
            Responder
        </span>
        </div>
        <br>
    </div>
@endforeach