@extends("master")
@section("title") Job #{{ $id }} - @parent @stop
@section("content")
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Job #{{ $id }}</h3>

                <div class="box-tools">
                    <span id="status" class="label label-primary" style="margin-bottom: 10px">
                    @if($task->status==0)
                            Waiting
                        @elseif($task->status ==1)
                            Running
                        @else
                            Finished
                        @endif
                    </span>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <pre id="content"
                     style="color: white;background-color: black;height: 450px;overflow: auto"><?= $task->content ?></pre>
            </div>
            <!-- /.box-body -->
            <!--<div class="box-footer clearfix">
                <button type="submit" class="btn btn-primary pull-right">Run</button>
            </div>-->

        </div>

    </div>
@endsection("content")

@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            var jobid = {{$id}};
            var ws = new WebSocket(socketString);
            ws.onopen = function (event) {
                ws.send(JSON.stringify({"command": SETJOBID, "jobid": jobid}));
            };
            ws.onmessage = function (event) {
                var data;
                try {
                    data = $.parseJSON(event.data);
                } catch (err) {
                    data = event.data;
                }
                if (typeof data.status == 'undefined') {
                    var content = $("#content");
                    content.append(data + "\n");
                    content.scrollTop(content.prop("scrollHeight"));
                }
                else {
                    $("#status").html(getStatus(data.status));
                }
            }
        });
    </script>
@endsection