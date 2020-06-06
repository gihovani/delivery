<?php $modalId = $modalId ?? 'status-modal'; ?>
<!-- Add and Edit customer modal -->
<div class="modal fade" id="{{$modalId}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group row">
                        {!! Form::label('deliveryman-id', __('Deliveryman'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-8">
                            {!! Form::select('deliveryman_id',\App\User::getDeliveryman(),'0',['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('deliveryman_id') ? ' is-invalid' : ''), 'id'=> 'deliveryman-id']) !!}
                            <span class="invalid-feedback invalid-deliveryman_id" role="alert">
                                <strong>@error('deliveryman_id') {{ $message }} @enderror</strong>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#{{$modalId}} form').on('submit', function (e) {
            e.preventDefault();
            var $this = $(this);
            if ($this.attr('action').length < 1) {
                myAlert('{{__('Problem with modal action')}}');
            }
            var data = $this.serialize();
            var url = $this.attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (response) {
                    $('#{{$modalId}}').trigger('saveSuccessEvent', response);
                },
                error: function (responseError) {
                    $('#{{$modalId}}').trigger('saveErrorEvent', responseError);
                }
            });
            return false;
        });
    });
</script>
