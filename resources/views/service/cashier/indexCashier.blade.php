@extends('layouts.app')

@section('content')
<div class="container">
    <div id="table-detail" class="row">
      show all table
    </div>
    <div class="row justify-content-center py-4">
        <div class="col-md-5">
          <button id="btn-show-tables" data-display="hide" class="btn btn-primary btn-block">View Tables</button>
          <div id="selected-table">
        
          </div>
          <div id="order-detail">
            
          </div>
        </div>
        <div class="col-md-7">
             {{-- Display Status --}}
              @if(Session()->has('status'))
              <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">x</button>
                  {{ Session()->get('status') }} &#x1F600;
              </div>
              @endif

                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach($categories as $category)
                  <a class="nav-item nav-link" data-id="{{$category->id}}" data-toggle="tab">{{$category->name}}</a>
                    @endforeach
                  </div>
                </nav>
            
            <div class="row mt-2" id="list-menu">
                
            </div>
      </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <h3 class="totalAmount"></h3>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">$</span>
          </div>
          <input type="number" id="recieved-amount" class="form-control" aria-label="Amount (to the nearest dollar)">
          <div class="input-group-append">
            <span class="input-group-text">.00</span>
          </div>
        </div>

        <div class="form-group">
          <label for="payment">Payment Type</label>
          <select class="form-control" id="payment-type">
            <option value="cash">Cash</option>
            <option value="credit card">Credit Card</option>
          </select>
        </div>


        <h3 id="changeAmount"></h3>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-save-payment" disabled>Save Payment</button>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function(){
  
   var SELECTED_TABLE = "";
   var SELECTED_TABLE_NAME = "";
   var SALE_ID = "";
 
  // list menus from the selected category
  $(".nav-link").click(function(){
        $.get( "/service/getMenuByCategory/"+ $(this).data("id"), function( data ) {
            $("#list-menu").hide();
            $("#list-menu").html(data);
            $("#list-menu").fadeIn('fast');
        });
  });

  // order food 
  $("#list-menu").on("click",".btn-menu", function(){
  
    if(SELECTED_TABLE == ""){
      alert("You need to pick a table for the customer first");
    }else{
      var menu_id = $(this).attr("data-id");
      
      $.ajax({
        type: "POST",
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), "menu_id": menu_id, "table_id" :  SELECTED_TABLE, "table_name" :  SELECTED_TABLE_NAME, "quantity" : 1}, 
        url: "/service/orderFood",
        success: function(data){
          $("#order-detail").html(data);
        }
      });

    }
  });

  // delete order 
  $("#order-detail").on("click",".btn-delete-order", function(){
    var saleID = $(this).attr("data-saleID");
    var saleDetailID = $(this).attr("data-saleDetailID");
    $.ajax({
        type: "POST",
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), "saleID": saleID, "saleDetailID" :  saleDetailID }, 
        url: "/service/deleteOrderFood",
        success: function(data){
          $("#order-detail").html(data);
        }
      });
  });
  
  $("#order-detail").on("click",".btn-confirm-order", function(){
      var saleID = $(this).attr("data-saleID");
      $.ajax({
        type: "POST",
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), "saleID": saleID }, 
        url: "/service/confirmOrderFood",
        success: function(data){
          $("#order-detail").html(data);
        }
      });
  });

  ///payment

  $("#order-detail").on("click",".btn-get-payment", function(){
     var totalAmount = $(this).attr('data-totalAmount');
     SALE_ID = $(this).attr('data-saleid');
     $(".totalAmount").html("Total Amout: " + totalAmount);
     $("#recieved-amount").val('');
     $("#changeAmount").html('');
  });

  $("#recieved-amount").keyup(function(){
    var totalAmount = $('.btn-get-payment').attr('data-totalAmount');
    var recievedAmount = $(this).val();
    var changeAmount = recievedAmount - totalAmount;
    $("#changeAmount").html("Total Change: $"+changeAmount);
    // check if user enter the right recieved amount, then enable or disable save payment button
    if(changeAmount >= 0){
      $('.btn-save-payment').prop('disabled', false);
    }else{
      $('.btn-save-payment').prop('disabled', true);
    }
  });

  $(".btn-save-payment").click(function(){
    var recievedAmount = $("#recieved-amount").val();
    var paymentType = $("#payment-type").val();

    $.ajax({
        type: "POST",
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), "saleID": SALE_ID, "recievedAmount" :  recievedAmount, "paymentType": paymentType}, 
        url: "/service/savePayment",
        success: function(data){
          window.location.href = data;
        }
    });


  });
 
  //Hide table detail by default
  $("#table-detail").hide();
  // show all tables
  $("#btn-show-tables").click(function(){
    if($("#table-detail").is(":hidden")){
        $.get( "/service/getTables", function( data ) {
          $("#table-detail").html(data);
          showTableDetail();
        });
    }else{
      hideTableDetail();
    }
  });

  ////////////
 


  //when user click on a table button
  $("#btn-create-sale").hide();
  $("#table-detail").on('click', '.btn-table', function(){
    SELECTED_TABLE = $(this).attr("data-id");
    SELECTED_TABLE_NAME = $(this).attr("data-name");
    $("#selected-table").html('<br><h3>Table: '+SELECTED_TABLE_NAME+'</h3><hr>');
    hideTableDetail();

    $.get("/service/getSale/"+ SELECTED_TABLE, function( data ) {
      $("#order-detail").html(data);
    });

  });

  function hideTableDetail(){
    $("#table-detail").slideUp('fast');
    $("#btn-show-tables").html('View Tables').removeClass('btn-danger').addClass('btn-primary');
  }

  function showTableDetail(){
    $("#table-detail").slideDown('fast');
    $("#btn-show-tables").html('Hide Tables').removeClass('btn-primary').addClass('btn-danger');
  }

});

</script>
@endsection
