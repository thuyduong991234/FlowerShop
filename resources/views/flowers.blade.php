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

@section('scripts')
    <script src="js/flower.js"></script>
@endsection