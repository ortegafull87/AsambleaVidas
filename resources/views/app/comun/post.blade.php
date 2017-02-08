@foreach($posts as $post)
    <div class="media">
        <div class="media-left media-middle">
            <a href="#">
                <!--<img alt="64x64" class="media-object" data-src="holder.js/64x64" style="width: 64px; height: 64px;"
                     src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTlkZThlMjQ2MiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OWRlOGUyNDYyIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNCIgeT0iMzYuNSI+NjR4NjQ8L3RleHQ+PC9nPjwvZz48L3N2Zz4="
                     data-holder-rendered="true">-->
                <img src="{{asset('/img/avatar04.png')}}" height="54" width="54">
            </a>
        </div>
        <div class="media-body">
            <h5 class="media-heading">{{$post->name}}</h5>
            <div class="text-comment">
                {{$post->comment}}
            </div>
            <div class="foot-post">
                <span class=""><i class="ion-clock"></i> {{\App\Library\Util::FORMAT_DATE_TO($post->created_at,'F j, Y, g:i a')}}</span>
                <span><a href="#"><i class="ion-edit"></i> Editar</a></span>
                <!--<span><a href="#"><i class="ion-forward"></i> Responder</a></span>-->
            </div>
        </div>
    </div>
@endforeach