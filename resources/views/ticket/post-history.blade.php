<div class="white-popup-block clearfix">
    @foreach($history as $change)
        <div class="clearfix">
            @if($change->fieldName() == 'body')
                <h4 class="changetime">{{$change->created_at->diffForHumans()}} the post looked like this:</h4>
                {!! $change->oldValue() !!}
                <p>
                    @if($change->userResponsible())
                        <em>{{$change->userResponsible()->name}}</em>
                    @else
                        <em>Ticket Owner</em>
                    @endif
                    Made some changes over this
                </p>
                <hr>
            @endif
        </div>
    @endforeach
</div>