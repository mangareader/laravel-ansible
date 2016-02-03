@extends("master")
@section("title") Jobs - @parent @stop
@section("content")
    <div class="col-xs-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">List Jobs</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th width="10%">#</th>
                        <th>Inventory</th>
                        <th>Template</th>
                        <th>Status</th>
                    </tr>

                    @foreach($tasks as $task)
                        <tr>
                            <td><a href="{{ route("job_run",["id"=>$task->id]) }}">#{{ $task->id }}</a></td>
                            <td>{{ $task->inventory->name }}</td>
                            <td>{{ $task->template->name }}</td>
                            <td>
                                <span class="label label-primary" id="status_{{$task->id}}">
                                   {{ $task->getStatus() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="pull-right">
                    {!! $tasks->links() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Run Job</h3>
            </div>
            <!-- /.box-header -->

            <form method="post" class="form-horizontal" action="" id="form">
                <div class="box-body">
                    @include("valid")
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Inventory</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="iid">
                                <option></option>
                                @foreach($invs as $inv)
                                    <option value="{{ $inv->id }}">{{ $inv->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Template</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="tid" id="template">
                                <option></option>
                                @foreach($templates as $inv)
                                    <option value="{{ $inv->id }}"
                                            rel="{{route("template_vars",["id"=>$inv->id])}}">{{ $inv->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Sudo</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="sudo">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Hosts</label>

                        <div class="col-sm-9">
                            <input type="text" name="hosts" class="form-control" value="all">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Variables</label>

                        <div class="col-sm-9">
                            <textarea id="vars" name="vars" class="hidden"></textarea>

                            <div id="editor" class="form-control"
                                 style="height: 200px"><?= isset($template) ? $template->vars : '{}' ?></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right">
                        <i class="fa fa-play-circle"></i> Run
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection("content")
@section("styles")

@endsection
@section("scripts")
    <script src="{{url("/res/ace/")}}/ace.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/xcode");
            editor.getSession().setMode("ace/mode/json");
            $("#form").submit(function () {
                $("#vars").val(editor.getValue());
                return true;
            });
            $("#template").change(function () {
                url = $("#template option:selected").attr("rel");
                $.get(url, function (data) {
                    editor.setValue(data);
                });
            });
            var ws = new WebSocket(socketString);
            ws.onopen = function (event) {
                ws.send(JSON.stringify({"command": SETJOBID, "jobid": 0}));
            };
            ws.onmessage = function (event) {
                var data;
                try {
                    data = $.parseJSON(event.data);
                } catch (err) {
                    return;
                }
                console.log(data);
                if (typeof data.status != 'undefined') {
                    var selector = $("#status_" + data.jid);
                    if (selector)
                        selector.html(getStatus(data.status));

                }
            };
        });
    </script>
@endsection