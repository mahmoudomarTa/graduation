@foreach($comments as $one)
    <div class="comment">
        <!-- Comment Avatar -->
        <div class="comment-avatar">
            <img src="{{@$one->user->image}}" >
        </div>

        <!-- Comment Box -->
        <div class="comment-box">
            <div class="comment-text">
                    {{$one->comment}}
            </div>
            <div class="comment-footer">
                <div class="comment-info">
                                        <span class="comment-author">
                                          <a>{{@$one->user->name}}</a>
                                        </span>
                    <span class="comment-date">{{@$one->created_at->diffForHumans()}}</span>
                </div>

            </div>
        </div>
    </div>

@endforeach
