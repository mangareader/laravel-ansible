@extends("master")
@section("title") {{ isset($template)?"Edit ":"Add " }}Template Job - @parent @stop
@section("content")
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">{{ isset($template)?"Edit ":"Add " }}Template Job</h3>
            </div>
            <!-- /.box-header -->

            <form method="post" class="form-horizontal" action="" id="form">
                <div class="box-body">
                    @include("valid")
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name"
                                   value="{{ isset($template)?$template->name:"" }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Roles</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="roles[]" id="roles" multiple>
                                <option></option>
                                @if(isset($template))
                                    @foreach($roles as $role)
                                        <option name="{{ $role }}" {{ in_array($role,$template->roles)?"selected":"" }}>{{ $role }}</option>
                                    @endforeach
                                @else
                                    @foreach($roles as $role)
                                        <option name="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Variables</label>

                        <div class="col-sm-9">
                            <div id="editor" class="form-control"
                                 style="height: 200px"><?= isset($template) ? $template->vars : '{}' ?></div>
                        </div>
                    </div>
                </div>
                <textarea id="vars" name="vars" class="hidden"></textarea>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div>
            </form>
        </div>

    </div>
@endsection("content")
@section("styles")
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet"/>
@endsection
@section("scripts")
    <script src="{{url("/res/ace/")}}/ace.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('select#roles').select2();
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/xcode");
            editor.getSession().setMode("ace/mode/json");
            $("#form").submit(function () {
                $("#vars").val(editor.getValue());
                return true;
            });
        });
    </script>
@endsection