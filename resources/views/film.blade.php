@php
    $categoryId = $squashed ? 0 : $category->id;

    $checked = $film
    ->votes()
    ->where('access_code_id', session('accessCodeId'))
    ->where('category_id', $categoryId)
    ->get()
    ->isEmpty() ? '' : 'checked';
@endphp


<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="category-{{$categoryId}}-film-{{$film->id}}-heading">
        <input type="radio" name="category-{{$categoryId}}-radios" value="{{$film->id}}" {{$checked}}>
        <h6 class="panel-title-film">
            <a role="button" data-toggle="collapse" data-parent="#accordion-{{$category->id}}"  href="#film-collapse-{{$category->id}}-{{$film->id}}" aria-expanded="true" aria-controls="film-collapse-{{$category->id}}-{{$film->id}}">
                {{$film->title}}
            </a>
        </h6>
    </div>
    <div id="film-collapse-{{$category->id}}-{{$film->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="category-{{$categoryId}}-film-{{$film->id}}-heading">
        <div class="poster-thumbnail">
            <img src="{{asset('img/manos-poster.jpg')}}" />
        </div>
        <div class="panel-body">
            {{$film->description}}
        </div>
    </div>
</div>