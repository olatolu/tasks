@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h4>Create A Task</h4>

            {!! Form::open(['route' => 'store.task', 'id'=>'create-task']) !!}

            @csrf

            <div class="row col-md-6 mt-2">
                <div class="form-group">
                    {!! Form::label('name','Task Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null, ['placeholder'=>'Insert Task Name', 'class'=>'form-control']) !!}
                </div>
            </div>

            <div class="row col-md-6 mt-2">
                <div class="form-group">
                    {!! Form::label('project_id','Select Project', ['class' => 'control-label']) !!}
                    {!! Form::select('project_id', $projects, null, ['placeholder'=>'Select Project', 'class'=>'form-control']) !!}
                </div>
            </div>

            <div class="row col-md-6 mt-4">
                <div class="form-group">
                    {!! Form::submit('SAVE', ['class'=>'btn btn-primary']) !!}
                </div>
            </div>

            <input type="hidden" name="order" id="" value="0">

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\UpdateTaskRequest::class, '#update-task'); !!}

@endsection
