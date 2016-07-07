@extends($revisionerClusterLayout)

@section('title')
Revisions
@endsection

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
                                    <th style="width: 200px">Date</th>
                                    <th style="width: 120px; text-align: center;">Is approved?</th>
                                    <th style="width: 120px; text-align: center;">Is revised?</th>
                                    <th>Fields</th>
                                </tr>
                                @foreach($revisionRecords as $revision)
                                    <tr>
                                        <td>{{ $revision->id }}</td>
                                        <td>{{ $revision->item_id ?: 'NEW' }}</td>
                                        <td>{{ $revision->user->name }}</td>
                                        <td>{{ $revision->created_at->diffForHumans() }}</td>
                                        <td style="text-align: center;">{!! $revision->approved ? '<i style="color: green" class="fa fa-check"></i>' : '<i style="color: red" class="fa fa-close"></i>' !!}</td>
                                        <td style="text-align: center;">{!! $revision->revised ? '<i style="color: green" class="fa fa-check"></i>' : '<i style="color: red" class="fa fa-close"></i>' !!}</td>
                                        <td><?php echo implode(' | ', array_keys(json_decode($revision->before, true))); ?></td>
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
