<li class="list-group-item ">
    <div class="row">
        <div class="col-sm-8">
            <h4 class="no-margin-top">{{ $user->name}}</h4>

            @include('users.partials.card-content', compact('user'))
        </div>

        <hr class="visible-xs-block mrg-v-10">

        <div class="col-sm-4 text-right no-wrap">
            @include('users.partials.action-buttons', [
                'user'    => $user,
                'showLabel' => false,
                'except'    => [ 'back' ],
            ])
        </div>
    </div>
</li>
