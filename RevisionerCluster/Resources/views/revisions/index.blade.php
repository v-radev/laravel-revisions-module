@extends($revisionerClusterLayout)

@section('title')
Revisions
@endsection

@section('header')
    <h1>A list of all revisions <small>All records are grouped by model name</small></h1>
@stop

@section('content')

    <div style="padding: 0 20px">
        @include('flash::message')

        @if($revisions->count())
            @foreach($revisions as $revisionModel => $revisionRecords)
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $revisionModel }}</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 50px">#ID</th>
                                    <th style="width: 80px">Model ID</th>
                                    <th style="width: 200px">By User</th>
                                    <th style="width: 140px">Date</th>
                                    <th style="width: 100px; text-align: center;">Revised?</th>
                                    <th style="width: 100px; text-align: center;">Approved?</th>
                                    <th>Fields</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                                @foreach($revisionRecords as $revision)
                                    <tr>
                                        <td>{{ $revision->id }}</td>
                                        <td>{{ $revision->item_id ?: 'NEW' }}</td>
                                        <td>{{ $revision->user->name }}</td>
                                        <td>{{ $revision->created_at->diffForHumans() }}</td>
                                        <td style="text-align: center;">{!! $revision->revised ? '<i style="color: green" class="fa fa-check"></i>' : '<i style="color: red" class="fa fa-close"></i>' !!}</td>
                                        <td style="text-align: center;">{!! $revision->approved ? '<i style="color: green" class="fa fa-check"></i>' : '<i style="color: red" class="fa fa-close"></i>' !!}</td>
                                        <td><?php echo implode(' | ', array_keys($revision->before, true)); ?></td>
                                        <td>
                                            <a href="{{ route($revisionRoutes . 'show', [$revision->id]) }}" class="btn btn-primary btn-sm pull-left" style="margin-right: 10px;">
                                                View
                                            </a>
                                            @unless( $revision->revised )
                                                @include($revisionerClusterViews .'common._delete', ['route' => [$revisionRoutes .'destroy', $revision->id], 'delete' => 'Delete'])
                                            @endunless
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection
