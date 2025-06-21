<style>
    .btnsave {
        background-color: #0070ff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 12px;
    }

    .btnsave:hover{
        background-color: #0070ff;
        color: white;
    }
</style>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Edit contact link </h5>

                <div data-bs-dismiss="modal">
                    <svg width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 21.32L21 3.32001" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 3.32001L21 21.32" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </div>
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
                <button type="button" class="btn btnsave" wire:click="saveContactLink">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
