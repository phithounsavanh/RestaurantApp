<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Menu;
use App\Table;
use App\Sale;
use App\User;
use App\SaleDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('service.cashier.indexCashier')
        ->with('categories', $categories);
    }

    public function getMenuByCategory($category_id){
        $menus = Menu::where('category_id', $category_id)->get();
        $html = '';
        foreach($menus as $menu){
            $html .= '<div class="col-md-3 text-center">';
            $html .= '<div class="btn-menu" data-id="'.$menu->id.'">';
            $html .=  '<img class="img-fluid" src="'.url('/menu_images/'.$menu->image).'">';
            $html .=  '<br>';
            $html .=  $menu->name;
            $html .=  '<br>';
            $html .=  '$'.number_format($menu->price);
            $html .= '</div>';
            $html .= '</div>';
        }
        echo $html;
    }

    public function getTables(){
        $tables = Table::all();
        $html = '';
        foreach($tables as $table){
           $html .= '<div class="col-md-2">';
           $html .= '<button data-id="'.$table->id.'" data-name="'.$table->name.'"  class="btn btn-primary btn-table">';
           $html .=  '<img class="img-fluid" src="'.url('/images/table.svg').'">';
           $html .= '<br>';
           if($table->status == "available"){
                $html .= '<span class="badge badge-success">'.$table->name.'</span>';
           }else{
                $html .= '<span class="badge badge-danger">'.$table->name.'</span>';
           }
           $html .= '</button>';
           $html .= '</div>';
        }
        
        echo $html;
    }

    public function getSale($table_id){
        $sale = Sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
        $html = '';
        if($sale){   
            $sale_id =  $sale->id;
            $html .= $this->getOrderTable($sale_id);
        }else{
            $html = 'Not Found Any Order For This Table';
        }
        return $html;

    }

    public function orderFood(Request $request){
        //received data from ajax
        $menu = Menu::find($request->menu_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $sale = Sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
        if(!$sale){
            $user = Auth::user();
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id; 
            
            //update table status
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        }else{
            $sale_id = $sale->id;
        }

        //add ordered menu to the sale_details table

        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_name = $menu->name;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();

        // update total price in the sales Table
        $sale->total_price = $sale->total_price + ($request->quantity *  $menu->price);
        $sale->save();
        $html = $this->getOrderTable($sale_id);        
        return $html;
    }

    public function deleteOrderFood(Request $request){
        $saleID = $request->saleID;
        $saleDetailID = $request->saleDetailID;
        
        $saleDetail = SaleDetail::find($saleDetailID);
        $menu_price = ($saleDetail->menu_price * $saleDetail->quantity); 
        $saleDetail->delete();

        $sale = Sale::find($saleID);
        $sale->total_price = $sale->total_price - $menu_price;
        $sale->save();

        $saleDetails = SaleDetail::where('sale_id', $saleID)->first();

        if($saleDetails){
            $html = $this->getOrderTable($saleID);
        }else{
            $sale->delete();
            $html = 'Not Found Any Order For This Table';
        }
        return $html;
    }

    public function confirmOrderFood(Request $request){
        $saleID = $request->saleID;
        $saleDetails = SaleDetail::where('sale_id', $saleID)->update(['status' => 'confirm']);
        $html = $this->getOrderTable($saleID);
        return $html;
    }

    public function savePayment(Request $request){
        //get sale information from ajax or view
        $saleID = $request->saleID;
        $recievedAmount = $request->recievedAmount;
        $paymentType = $request->paymentType;

        // update sale information in database by using Sale Model
        $sale = Sale::find($saleID);
        $sale->total_recieved = $recievedAmount;
        $sale->change = $recievedAmount - $sale->total_price;
        $sale->payment_type = $paymentType;
        $sale->sale_status = "paid";
        $sale->save();

        // update table to be available
        $table = Table::find($sale->table_id);
        $table->status = "available";
        $table->save();
        return '/service/cashier/showReceipt/'.$saleID;
    }

    public function showReceipt($saleID){
        $sale = Sale::find($saleID);
        $saleDetails = SaleDetail::where('sale_id', $saleID)->get();
        return view('service.cashier.showReceipt')
        ->with('sale', $sale)
        ->with('saleDetails', $saleDetails);
    }

    private function getOrderTable($saleID){
        $html ='<p>Sale ID: '.$saleID.'</p>';
        //list all seledetail from sale_id
        $saleDetails = SaleDetail::where('sale_id', $saleID )->get(); 
        $html .= '<div class="table-responsive-md" style="overflow-y: scroll;height: 400px;border: 1px solid #343A40">';
        $html .= '<table class="table table-striped table-dark">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th scope="col">ID</th>';
        $html .= '<th scope="col">Menu</th>';
        $html .= '<th scope="col">Quantity</th>';
        $html .= '<th scope="col">Price</th>';
        $html .= '<th scope="col">Total</th>';
        $html .= '<th scope="col">Status</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '</tbody>';
        $showBtnPayment = true;
        foreach($saleDetails as $saleDetail){
            $html .= '<tr>';
            $html .= '<td>'.$saleDetail->menu_id.'</td>';
            $html .= '<td>'.$saleDetail->menu_name.'</td>';
            $html .= '<td>'.$saleDetail->quantity.'</td>';
            $html .= '<td>'.$saleDetail->menu_price.'</td>';
            $html .= '<td>'.($saleDetail->menu_price * $saleDetail->quantity).'</td>';
            $html .= '<td>';
            if( $saleDetail->status == "noConfirm"){
                $showBtnPayment = false;
                $html .= '<a data-saleID="'.$saleID.'" data-saleDetailID="'.$saleDetail->id.'" class="btn btn-danger btn-delete-order text-light"><i class="far fa-trash-alt"></i></a>';
            }else{
                $html .= '<i class="fas fa-check-circle"></i>';
              
            }   
            $html .='</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        $sale = Sale::find($saleID);

        $html .= '<hr>';
        $html .= '<h3>Total Amount: $'.$sale->total_price.'</h3>';

        //create confirm order button
        if($showBtnPayment){
            $html .= '<button data-saleID="'.$saleID.'" data-totalAmount="'.$sale->total_price.'" class="btn btn-success btn-block btn-get-payment" data-toggle="modal" data-target="#exampleModal">Payment</button>';
        }else{
            $html .= '<button data-saleID="'.$saleID.'" class="btn btn-warning btn-block btn-confirm-order">Confirm Order</button>';
         
        }
        


        return $html;
    }

    
}
