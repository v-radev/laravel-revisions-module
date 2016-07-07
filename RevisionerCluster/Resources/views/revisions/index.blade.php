@extends($revisionerClusterLayout)

@section('title')
Revisions
@endsection

@section('content')

    <div style="padding: 0 20px">
        @include('flash::message')

        @if($revisions->count())
            <ul>
                @foreach($revisions as $revision)
                    <li>{{ $revision->model }}</li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection
