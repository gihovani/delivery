<?php $modalId = $modalId ?? 'product-modal'; ?>
<div class="modal" tabindex="-1" role="dialog" id="{{$modalId}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#{{$modalId}}').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var modal = $(this);

            modal.find('.modal-body')
                .load(button.data("remote"));
        });
    });
</script>
