@php
    $nameAttribute = 'category-0-film';
    $categoryLookup = 0;

    if(!$squashed) {
        $nameAttribute = "category-{$category->id}-film";
        $categoryLookup = $category->id;
    }

    $checked = $film
    ->votes()
    ->where('access_code_id', session('accessCodeId'))
    ->where('category_id', $categoryLookup)
    ->get()
    ->isEmpty() ? '' : 'checked';
@endphp

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="film-heading-{{$category->id}}-{{$film->id}}">
        <h6 class="panel-title-film">
            <a role="button" data-toggle="collapse" data-parent="#accordion-{{$category->id}}" href="#film-collapse-{{$category->id}}-{{$film->id}}" aria-expanded="true" aria-controls="film-collapse-{{$category->id}}-{{$film->id}}">
                {{$film->title}}
            </a>
        </h6>
    </div>
    <div id="film-collapse-{{$category->id}}-{{$film->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="film-heading-{{$category->id}}-{{$film->id}}">
        <div class="panel-body">
            {{$film->description}}
        </div>
    </div>
</div>