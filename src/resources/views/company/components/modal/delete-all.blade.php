<div class="modal fade" id="modal-delete-all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{__('labels.CM001_L014')}}</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-text-delete mb-0"></p>
            </div>
            <div class="modal-footer">
                <form action="" method="post" id="delete-all-form">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('labels.CM001_L013')}}</button>
                    <button type="submit" class="btn btn-danger delete-all ml-2">{{__('labels.CM001_L005')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>