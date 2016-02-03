@extends("master")

@section("content")
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    @if(isset($inv))
                        Edit Inventories
                    @else
                        Add Inventories
                    @endif
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include("valid")
                <form method="post" class="form-horizontal" action="">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ isset($inv)?$inv->name:"" }}">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content</label>

                        <div class="col-sm-9">
                            <textarea rows="15" class="form-control" name="noidung">{{ isset($inv)?$inv->content:"" }}</textarea>
                        </div>
                    </div>


                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-5">
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection("content")
