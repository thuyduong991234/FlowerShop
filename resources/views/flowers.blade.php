@extends('layout')

@section('content')
    <h2>Flowers</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="tbFlower">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Delete</th>
                <th scope="col">Edit</th>
                <th>ID</th>
                <th>Catalog</th>
                <th>Name</th>
                <th>Color</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Avatar</th>
                <th>Images</th>
                <th>View</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <nav aria-label="...">
            <ul class="pagination" id = "ul-pagination">
            </ul>
        </nav>
    </div>
@endsection

@section('modalDetailItem')
    <div class="modal fade" id="modalDetailItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="col-form-label">Name:</label>
                            <label style="color: red; font-weight: bold">(*)</label>
                            <input type="text" class="form-control" id="catalog-name" placeholder="Enter catalog name...">
                            <div id="noteName" style="display: none">
                                <i class="fas fa-exclamation-triangle" style="color: red"></i>
                                <span style="color: red" id="message-note-name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Catalog:</label>
                            <select class="form-control" id="select-catalog-id"></select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Flower color:</label>
                            <label style="color: red; font-weight: bold">(*)</label>
                            <input type="color" class="form-control" id="color" value="#ff0000">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancel">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="js/flower.js"></script>
@endsection