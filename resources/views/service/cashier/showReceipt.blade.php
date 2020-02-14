<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Resturant App - receipt - SaleID : {{$sale->id}}</title>
        <style type="text/css" media="all">
            #wrapper { width: 280px; margin: 0 auto; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:12px; }
            #wrapper img { width: 80%; }
            h3 { margin: 5px 0; }
            .left { width:60%; float:left; text-align:left; margin-bottom: 3px; }
            .right { width:40%; float:right; text-align:right; margin-bottom: 3px; }
            .table, .totals { width: 100%; margin:10px 0; }
            .totals{margin-top: 10px; margin-bottom: 0px;}
            .table th { border-bottom: 1px solid #000; }
            .table td { padding:0; }
            .totals td { width: 24%; padding:0; }
            .table td:nth-child(2) { overflow:hidden; }
        </style>
        <style type="text/css" media="print">
            #buttons { display: none; }
        </style>
    </head>

    <body>
        <div id="wrapper">
            <h3>Restuarant App Devtamin</h3> 
            <p style="text-transform:capitalize;"></p>
            <span class="left">Address: 341 N Vakanda Ave, Analpolis, md 1334 </span> 
            <span class="left">Tel: 447-xxxx-xxxx </span> 
            <span class="left">Reference receipt: <strong>{{$sale->id}}</strong></span> 
            <table class="table" cellspacing="0"  border="0"> 
                <thead> 
                    <tr> 
                        <th><em>#</em></th> 
                        <th>Menu</th> 
                        <th>Qty</th>
                        <th>Price</th> 
                        <th>Total</th> 
                    </tr> 
                </thead> 
                <tbody> 
                      @foreach($saleDetails as $saleDetail)
                        <tr>
                        <td style="text-align:center; width:30px;">{{$saleDetail->menu_id}}</td>
                            <td style="text-align:left; width:180px;">{{$saleDetail->menu_name}}</td>
                            <td style="text-align:center; width:50px;">{{$saleDetail->quantity}}</td>
                            <td style="text-align:right; width:55px; ">{{$saleDetail->menu_price}}</td>
                        <td style="text-align:right; width:65px;">{{($saleDetail->menu_price * $saleDetail->quantity)}}</td> 
                        </tr> 
                      @endforeach
                   
                </tbody> 
            </table> 

            <table class="totals" cellspacing="0" border="0">
                <tbody>
                    <tr>
                        <td style="text-align:left;">Total quantity</td>
                        <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #999;font-weight:bold;">{{$saleDetails->count()}}</td>
                        <td style="text-align:left; padding-left:1.5%;">Total</td><td style="text-align:right;font-weight:bold;">${{number_format($sale->total_price, 2)}}</td>
                    </tr>
                    <tr style="background-color: #cccccc">
                        <td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Payment Type</td><td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;">{{$sale->payment_type}}</td>
                    </tr>
                    <tr style="background-color: #cccccc">
                        <td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Paid Amount</td><td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;">${{number_format($sale->total_recieved, 2)}}</td>
                    </tr>
                    
                    <tr style="background-color: #cccccc">
                        <td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Change</td><td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;">${{ number_format( $sale->total_recieved - $sale->total_price , 2) }}</td>
                    </tr>
                </tbody>
            </table>
          

            <div style="border-top:1px solid #000; padding-top:10px;">Thank You!!!</div>

                <div id="buttons" style="padding-top:10px; text-transform:uppercase;margin-top:30px">
                <span class="left"><a href="/service/cashier" style="width:80%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 1px; border-radius:5px;">Back to Order</a></span>
                <span class="right"><button type="button" onClick="window.print();
                        return false;" style="width:80%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 1px; border-radius:5px;">Print</button></span>
                <div style="clear:both;"></div>
            </div>
        </div>
    </body>
</html>
