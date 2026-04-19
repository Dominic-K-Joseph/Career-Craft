<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\DB;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function createSession(Request $request)
    {
        $loginId = session('login_id');

        // Get plan + amount from form
        $plan = $request->plan;
        $amount = $request->amount;

        // Safety check
        if (!$plan || !$amount) {
            return back()->with('error', 'Invalid plan selected');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => ucfirst($plan) . ' Plan',
                    ],
                    'unit_amount' => $amount, // dynamic
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'success_url' => route('seeker.payment.page') . '?success=1&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('seeker.payment.page') . '?cancel=1',
        ]);

        // Get seeker_id from login_id
        $seekerId = DB::table('tbl_seeker_profile')
            ->where('login_id', $loginId)
            ->value('id');

        if (!$seekerId) {
            return back()->with('error', 'Seeker not found');
        }

        // Save to DB
        DB::table('tbl_payment')->insert([
            'seeker_id' => $seekerId,
            'session_id' => $session->id,
            'amount' => $amount / 100, // convert paise → rupees
            'plan' => $plan,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect($session->url);
    }

    public function webhook(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Handle success payment
        if ($event->type == 'checkout.session.completed') {

            $session = $event->data->object;

            DB::table('tbl_payment')
                ->where('session_id', $session->id)
                ->update([
                    'payment_intent' => $session->payment_intent,
                    'status' => 'success',
                    'updated_at' => now()
                ]);
        }

        // Handle failed (optional)
        if ($event->type == 'payment_intent.payment_failed') {

            $paymentIntent = $event->data->object;

            DB::table('tbl_payment')
                ->where('payment_intent', $paymentIntent->id)
                ->update([
                    'status' => 'failed',
                    'updated_at' => now()
                ]);
        }

        return response()->json(['status' => 'success']);
    }
}
