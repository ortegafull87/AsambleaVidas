<!-- About Me Box -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Mis notas</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if(count($notes)>0)
            @foreach($notes as $note)
                <strong><i class="fa fa-file-text-o margin-r-5"></i> {{$note->title}}</strong>
                <p class="text-muted" style="margin-left: 20px;">{{$note->updated_at}}</p>
                <p>{{$note->note}}</p>
            @endforeach
        @else
            @include('app.comun.no-content-message')
        @endif
    </div>
    <!-- /.box-body -->
    @if(count($notes)> env('ROWS_NOTE_PROFILE'))
        <div class="box-footer text-center">
            <a href="#" class="app-link">Mostrar todas</a>
        </div>
    @endif
</div>
<!-- /.box -->