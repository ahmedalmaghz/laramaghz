@extends('laramaghz::admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('laramaghz::laramaghz.laramaghz Import')
            <small>
                @lang('laramaghz::laramaghz.Here you Can Upload any module you generated with laramaghz')
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> @lang('laramaghz::laramaghz.Home')</a></li>
            <li><a class="active"> @lang('laramaghz::laramaghz.laramaghz Import')</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="callout callout-info">
            <h4> @lang('laramaghz::laramaghz.laramaghz Import') !</h4>
            <p>@lang('laramaghz::laramaghz.Here you Can Upload any module you generated with laramaghz')</p>
        </div>
        <!-- Default card -->
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">@lang('laramaghz::laramaghz.laramaghz Import')</h3>
                <div class="card-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            {!! Form::open(['route' => 'post-import', 'role' => 'form' , 'files' => true]) !!}
                <div class="card-body">
                    @include('laramaghz::fileds.php.file' , ['name' => 'module' , 'value' => ''])
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {!! Form::submit(trans('laramaghz::laramaghz.Save') , ['class' => 'btn btn-info']) !!}
                </div>
            {!! Form::close() !!}
        <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
