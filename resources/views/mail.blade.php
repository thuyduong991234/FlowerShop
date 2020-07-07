<h2>The Bill</h2>
<div>
    <p>Last name: {{ $transaction->customer_last_name }}</p>
    <p>First name: {{ $transaction->customer_first_name }}</p>
    <p>Phone: {{ $transaction->customer_phone }}</p>
    <p>Amount: {{ $transaction->amount }}</p>
    <p>Payment method: {{ $transaction->payment_method }}</p>
    <p>Payment info: {{ $transaction->payment_info }}</p>
    <p>Message: {{ $transaction->message }}</p>
    <p>Date: {{date("d/m/Y", strtotime($transaction->created_at ))}}</p>
    <table class="table table-striped table-sm" id="tbFlower">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th>Flower</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transaction->flowers as $f)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$f->name}}</td>
                <td>{{$f->pivot->qty}}</td>
                <td>{{$f->pivot->amount}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>