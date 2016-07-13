@extends($revisionerClusterLayout)

@section('title')
Show revision
@endsection

@section('content')

    <div style="padding: 0 20px">
        @include('flash::message')
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <div class="callout">
                <h3>{{ $revision->model }}</h3>
            </div>
            <h4>
                Made by {{ $revision->user->name }} - {{ $revision->created_at->diffForHumans() }}.
                {!! $revision->revised ? '<b style="color: green">Already revised</b>' : '<b style="color: red">Not yet revised</b>' !!} and
                {!! $revision->approved ? '<b style="color: green">approved</b>' : '<b style="color: red">not approved</b>' !!}.
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Before</h3>
                </div>
                <div class="box-body">
                    @foreach( $revision->before as $field => $change )
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ ucfirst($field) }}</h3>
                            </div>
                            <div class="box-body">
                                {{ $change }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">After</h3>
                </div>
                <div class="box-body">
                    @forelse( $revision->after as $field => $change )
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ ucfirst($field) }}</h3>
                            </div>
                            <div class="box-body">
                                {{ $change }}
                            </div>
                        </div>
                    @empty
                        <div class="callout callout-info">
                            <h4>This is a new item</h4>
                            <p>Because this item is newly created there are no changes in the data to be shown here. When you click <b>Approve</b> the item is going to be created. If you click <b>Reject</b> the item won't be created and this revision will be stored as reference.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-footer">
                    <a class="btn btn-primary" href="{{ route($revisionRoutes . 'index') }}" style="margin-right: 15px;">Go Back</a>
                    @unless( $revision->revised )
                        <button class="btn btn-success btn-lg" type="submit" style="margin-right: 15px;">Approve</button>
                        <button class="btn btn-danger btn-lg" type="submit">Reject</button>
                    @endunless
                </div>
            </div>
        </div>
    </div>
@endsection
