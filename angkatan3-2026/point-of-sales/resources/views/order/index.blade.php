@extends('app')
@section('content')
<div class="table-responsive p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Transaction List</h4>
        <a href="{{ route('order.create') }}" class="btn btn-primary">New Transaction</a>
    </div>

    <table class="table table-striped table-hover align-middle border">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Order Code</th>
                <th>Customer</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Items Purchased</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><span class="fw-bold">{{ $order->order_code }}</span></td>
                <td>{{ $order->customer_name ?? 'Guest' }}</td>
                <td><span class="badge bg-info text-dark">{{ strtoupper($order->payment_method ?? 'Cash') }}</span></td>
                <td>Rp. {{ number_format($order->order_amount, 0, ',', '.') }}</td>
                <td>
                    @if($order->status == 1)
                    <span class="badge bg-success">Success</span>
                    @else
                    <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>
                    <ul class="mb-0 ps-3">
                        @foreach($order->orderDetails as $detail)
                        <li>
                            {{ $detail->product->name ?? 'Product Deleted' }}
                            (x{{ $detail->order_qty }})
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info text-white">Detail</a>
                        <form action="{{ route('order.destroy', $order->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">No transactions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
