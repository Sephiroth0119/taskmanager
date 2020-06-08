<!-- Modal -->
<div class="modal fade" id="editProjectMode-{{ $project->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editProjectMode-{{ $project->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">编辑项目</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {!! Form::model($project,['route'=>['projects.update',$project->id],'method'=>'PATCH','files'=>'true']) !!}
            </div>
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('name', '项目名称：') !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('thumbnail', '项目缩略图：') !!}
                    {!! Form::file('thumbnail', ['class'=>'form-control-file']) !!}
                </div>

                @include('errors._errors')


            </div>
            <div class="modal-footer">
                {!! Form::submit('编辑项目', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
