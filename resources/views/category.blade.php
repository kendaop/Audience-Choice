@php $films = $category->getFilms() @endphp
@if(!$films->isEmpty())
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading-{{$category->id}}">
            <h3 class="panel-title-category">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$category->id}}" aria-expanded="false" aria-controls="collapse-{{$category->id}}">
                    {{$category->name}}
                </a>
            </h3>
        </div>

        <div id="collapse-{{$category->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$category->id}}">
            <div class="panel-group" id="accordion-{{$category->id}}" role="tablist" aria-multiselectable="true">
                @foreach($films as $film)
                    @include('film', [
                        'category' => $category,
                        'squashed' => $squashed
                    ])
                @endforeach
            </div>
        </div>
    </div>
@endif