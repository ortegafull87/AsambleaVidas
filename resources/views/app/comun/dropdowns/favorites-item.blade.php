@foreach($favorites as $favorite)
    <li>
        <a href="{{asset('estudios/audios/post/'.$favorite->id.'/track')}}" id="{{$favorite->id}}"
           title="{{$favorite->title}}">
            <!-- Message title and timestamp -->
            <h4>
                {{str_limit($favorite->title,20)}}
                <small> {{$favorite->genre}}</small>
            </h4>
            <!-- The message -->
            <p>{{$favorite->author}}</p>
        </a>
    </li>
@endforeach