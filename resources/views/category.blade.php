@php $films = $category->getFilms() @endphp
@if(!$films->isEmpty())
    <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-{{$category->id}}">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$category->id}}" aria-expanded="false" aria-controls="collapse-{{$category->id}}">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="panel-title-category">
                                {{$category->name}}
                            </h3>
                        </div>
                        <div class="col-xs-2">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </div>
                    </div>
                </a>
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