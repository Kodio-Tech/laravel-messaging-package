<div class="card">
    <div class="card-header bg-primary text-white">
        {{ __('kodio::messaging.new-message') }}
    </div>
    <div class="card-body">

        <form action="{{ route('kodio::laravel-messaging-send-message') }}" method="POST">

            @if (session('status', false) == 'sended')
                <div class="alert alert-success">
                    {{ __('kodio::messaging.status-sended') }}
                </div>
            @endif
            @if (session('status', false) == 'error')
                <div class="alert alert-danger">
                    {{ __('kodio::messaging.status-error') }}
                </div>
            @endif

            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">{{ __('kodio::messaging.message-title') }}</label>
                        <input id="title" class="form-control" type="text" name="title" required value="{{ old('title') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="my-input">{{ __('kodio::messaging.target-user') }}</label>
                        <select name="target_user_id" id="kodio-messaging-target-user-select" class="form-control" required>
                            @foreach (App\Models\User::pluck('name', 'id') as $userId => $name)
                                <option {{ old('target_user_id', false) == $userId ? 'selected' : '' }} value="{{ $userId }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <textarea name="message" class="tinymce">{{ old('message') }}</textarea>

            <button class="btn btn-success mt-2">
                {{ __('kodio::messaging.send-message') }}
            </button>
        </form>

    </div>
</div>

<h3 class="mb-3">
    {{ __('kodio::messaging.incoming') }}
</h3>
<hr>

<div class="accordion" id="accordionKodioMessaging">
@forelse (Kodio\LaravelMessaging\Models\Message::getLoggedUserMessages() as $index => $message)
    <div class="card">
        <div class="card-header" id="heading{{ $index }}">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                        {{ $message->title ?? '' }}
                    </button>
                </div>
                <div class="d-flex align-items-baseline">
                    <p class="text-left text-dark mb-0 mr-3" data-toggle="collapse"
                        data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                        {{ __('kodio::messaging.sended-by') }}: <strong>{{ $message->sendedBy->name ?? '' }}</strong>
                    </p>
                    @if ($message->isReaded())
                        <div class="badge badge-success">
                            {{ __('kodio::messaging.readed') }}
                        </div>
                    @else
                        <a class="btn btn-xs btn-primary" href="{{ route('kodio::laravel-messaging-mark-as-readed', $message->id) }}">
                            {{ __('kodio::messaging.mark-as-read') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#accordionKodioMessaging">
            <div class="card-body">
                {!! $message->message ?? '' !!}
            </div>
        </div>
    </div>

</div>
@empty
    <h4 class="text-center">
        {{ __('kodio::messaging.empty') }}
    </h4>
@endforelse

