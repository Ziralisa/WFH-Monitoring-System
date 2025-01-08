<!-- Modal -->
<div wire:ignore.self class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Edit contact link </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="saveContactLink" action="#" method="POST" role="form text-left">
                    <div class="form-group">
                        <label for="contact-link" class="col-form-label">Link (Whatsapp/Telegram/etc.)</label>
                        <input id="contact-link" type="text" class="form-control" wire:model.defer="contactLink"
                            placeholder="https://wa.me/1234567890 @ https://t.me/johndoe">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" wire:click="saveContactLink">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
