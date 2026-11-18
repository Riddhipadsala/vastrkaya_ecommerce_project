<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-body text-center p-4">

                <i class="bi bi-trash3-fill text-danger fs-1"></i>

                <h5 class="fw-bold mt-3">Delete Option?</h5>

                <p class="text-muted small">
                    Are you sure you want to delete
                    <strong id="deleteOptionNameDisplay">this option</strong>?
                </p>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light border"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-danger"
                            id="confirmDeleteBtn">
                        <i class="bi bi-trash3"></i> Delete
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>