@if($audio->rate == 5 || ($audio->rate > 4.5))
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star" aria-hidden="true"></i></a>
@elseif($audio->rate == 4.5)
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 4 || ($audio->rate > 3.5))
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 3.5)
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 3 || ($audio->rate > 2.5))
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 2.5)
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 2 || ($audio->rate > 1.5))
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 1.5)
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 1 || ($audio->rate > 0.5))
    <a href="" id="1"><i class="fa fa-star" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 0.5)
    <a href="" id="1"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@elseif($audio->rate == 0 || ($audio->rate > 0))
    <a href="" id="1"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="2"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="3"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="4"><i class="fa fa-star-o" aria-hidden="true"></i></a>
    <a href="" id="5"><i class="fa fa-star-o" aria-hidden="true"></i></a>
@endif