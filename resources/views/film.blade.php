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
        <div class="row">
            <div class="col-xs-1">
                <input type="radio" name="category-{{$categoryId}}-radios" value="{{$film->id}}" {{$checked}}>
            </div>
            <a role="button" class="film" data-toggle="collapse" data-parent="#accordion-{{$category->id}}"  href="#film-collapse-{{$category->id}}-{{$film->id}}" aria-expanded="false" aria-controls="film-collapse-{{$category->id}}-{{$film->id}}">
                <div class="col-xs-9">
                    <h6 class="panel-title-film">
                        {{$film->title}}
                    </h6>
                </div>
                <div class="col-xs-2">
                    <span class="glyphicon glyphicon-menu-down"></span>
                </div>
            </a>
        </div>
    </div>
    <div id="film-collapse-{{$category->id}}-{{$film->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="category-{{$categoryId}}-film-{{$film->id}}-heading">
        <div class="poster-thumbnail">
            <img src="{{asset("img/posters/$film->id.jpg")}}" />
        </div>
        <div class="panel-body">
            {{$film->description}}
        </div>
    </div>
</div>