@extends('layouts.app')

@section('content')

    @push('after-styles')
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/sorter-master/css/theme-default.css')}}">
    @endpush
    <div class="container">
        @if(count($tasks) > 0)
            <div class="row justify-content-center">
                <div class="col-lg-12 col-12  ">
                    <div class="col-md-3 mb-2">Filter By Project: <select name="project" class="d-inline"
                                                                          id="filter-by-project">
                            <option value="" selected disabled>Select Option</option>
                            @foreach($projects as $key=>$project)
                                <option
                                    value="{{$key}}" {{(\request()->query('project_id') == $key) ? 'selected':''}}>{{$project}}</option>
                            @endforeach
                        </select></div>
                    <ul class="sorter d-inline-block">

                        @foreach($tasks as $key=>$task)
                            <li>
                                        <span data-id="{{$task->id}}" data-name="{{$task->name}}">
                                                <p class="title d-inline">{{$task->name}}</p>
                                            <div class="float-end action-menu">

                                                <a class="nav-link nav-action" href="#" role="button"
                                                   data-bs-toggle="dropdown" data-modal="modal{{$task->id}}"
                                                   aria-expanded="false">
                                                    ...
                                                </a>
                                            </div>
                                     </span>
                            </li>
                            <!-- Modal -->
                            <div class="modal fade" id="modal{{$task->id}}" tabindex="-1" role="dialog"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{$task->name}}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="{{route('edit.task',$task->id)}}"
                                                       class="d-inline-block btn btn-info w-50">Edit</a>
                                                </div>
                                                <div class="col-6">
                                                    {!! Form::open(['method'=>'DELETE', 'route' => ['delete.task', $task]]) !!}
                                                    @csrf
                                                    <button type="submit"
                                                            class="d-inline-block btn btn-danger action-btn w-50 float-end">
                                                        Delete
                                                    </button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary dismiss"
                                                    data-dismiss="modal{{$task->id}}">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>

                </div>

            </div>
        @else

            <p class="text-muted">No Record Found. <a href="{{route('create.task')}}">Create A Task</a></p>

        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/sorter-master/js/amigo-sorter.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $("#filter-by-project").change(function () {
                window.location = "{{route('home')}}?project_id=" + $(this).find(":selected").val()
            });

            $(".nav-action ").mouseover(function () {
                var modal = $(this).data('modal');
                $('#' + modal).modal('show');
            });

            $(".dismiss").click(function () {
                var modal = $(this).data('dismiss');
                $('#' + modal).modal('hide');
            });

            $(function () {
                $('ul.sorter').amigoSorter({
                    li_helper: "li_helper",
                    li_empty: "empty",
                    onTouchEnd: function () {
                        console.log('drag event finished');

                        $(".action-btn").click(function () {
                            console.log('I am clkicked');
                        });

                        var list = [];
                        $('ul.sorter li').each(function (key, value) {
                            key++;
                            var id = $(value).find('span').data('id');
                            var name = $(this).find('span').data('name');
                            list.push({id: id, name: name, order: key});
                        });

                        $.ajax({
                            method: 'POST',
                            url: "{{route('save.order.task')}}",
                            data: {
                                _token: '{{csrf_token()}}',
                                tasks: list
                            }
                        }).done(function () {
                            console.log("Task order saved successfully!");
                        });

                    }
                });
            });

        });

    </script>

@endsection
