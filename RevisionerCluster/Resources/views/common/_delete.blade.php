<?php
$delete = isset( $delete ) ? $delete : 'Delete';
?>
{!! Form::open(['method' => 'DELETE', 'route' => $route, 'class' => 'form-inline']) !!}
<button type="submit" class="btn btn-danger btn-sm">{{ $delete }}</button>
{!! Form::close() !!}
