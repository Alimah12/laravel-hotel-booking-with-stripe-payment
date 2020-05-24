<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TotalPrice;
use DB;
use Cart;

class FinalBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bookings = DB::select('select * from bookings where user_id =:user_id',['user_id' => auth()->user()->id]);
        return view('pages.finalPayment')->with('bookings',$bookings);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get the total amount and email from the text box
        $total_amount = $request->input('total');
        $email = $request->input('email');
         //replaces the commas and decimal on the total amount
        $new_total = str_replace(',','',$total_amount);
        $amount = str_replace('.','',$new_total);
       try{
        \Stripe\Stripe::setApiKey('sk_test_1llQ7a6Ha5q9I0ztYNZoMEmR00qlgGPsy2');
        // `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/accept-a-payment-charges#web-create-token
        \Stripe\Charge::create([
          'amount' => $amount,
          'currency' => 'usd',
          'source' => $request->stripeToken,
          'description' => 'Booking Charge',
          'receipt_email' => $email
        ]);
        return redirect('/checkout')->with('success_message','Thank you for choosing us,
        Have a nice stay');
       }
       catch(Exception $ex) {

       }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
