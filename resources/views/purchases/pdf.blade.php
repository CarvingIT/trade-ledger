<!DOCTYPE html>
<html>
<head>
    <title>Purchase</title>
    <style>
        body { font-family: sans-serif; }
        .purchase-box-box { border: 1px solid #eee; padding: 30px; }
        table { width: 100%; line-height: inherit; text-align: left; }
        .text-right{
            text-align:right;
        }
        .text-left{
            text-align:left;
            padding-top:10%;
        }
        .item{
            text-align:right;
            width:10%;
        }
        .item-name{
            text-align:center;
            width:20%;
        }
    </style>
</head>
<body>
    <div class="purchase-box">
        <h1>Purchase #{{ $purchase->id }}</h1>
        <p><b>Vendor</b>: {{ $purchase->entity->name }}</p>
        <p><b>Date:</b> {{ $purchase->created_at->format('d/m/Y') }}</p>
        <p><b>Description</b>: {{ $purchase->description }}</p>

        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($line_items as $line_item)
                <tr>
                    <td class="item-name">{{ $line_item->item_name }}</td>
                    <td class="item">Rs. {{ $line_item->rate }} / {{ $line_item->product->unit_detail->name }}</td>
                    <td class="item">{{ $line_item->quantity }}</td>
                    <td class="item">{{ $line_item->amount }}</td>
                </tr>
                @endforeach
                <tr>
                    <th class="text-right">Total Amount</th>
                    <td colspan="3" class="text-right">Rs. {{ $purchase->total_amount }}</td>
                </tr>
                <tr>
                    <th class="text-right">Tax</th>
                    <td colspan="3" class="text-right">{{ @$purchase->tax_name }} - {{ @$purchase->tax_value }} </td>
                </tr>
                <tr>
                    <th class="text-right">Total Amount including Tax</th>
                    <td colspan="3" class="text-right">Rs. {{ number_format($total_amount_including_tax, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-left">
            Yours faithfully,<br />
            {{ $purchase->owner_entity->name }}
        </div>    
        <div class="text-right">
            Thank you for your business.
        </div>    
    </div>
</body>
</html>

