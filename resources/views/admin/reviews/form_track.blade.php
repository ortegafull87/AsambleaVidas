<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-music"></i></span>
    <input id="trk_titulo" class="form-control" placeholder="titulo" type="text"
           value="{{$pistas[0]->title}}" disabled="disabled">
</div>
<br>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa  fa-user"></i></span>
        <input class="form-control" placeholder="Autor" value="{{$pistas[0]->firstName .' '. $pistas[0]->lastName}}"
               disabled="disabled">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-folder"></i></span>
        <input class="form-control" placeholder="Albume" value="{{$pistas[0]->titleAlbume}}" disabled="disabled">
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-tag"></i></span>
        <input class="form-control" placeholder="Genero" value="{{$pistas[0]->genre}}"
               disabled="disabled">
    </div>
</div>
<div class="form-group">
    <label>Documentaci&oacute;n</label>
    <textarea id="documentacion" name="documentacion" rows="50" cols="80" style="visibility: hidden; display: none;"><?php echo $pistas[0]->description?></textarea>
</div>