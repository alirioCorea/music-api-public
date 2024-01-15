<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\PaypalAccount;
use App\Models\CreditCard;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        // Validar que el usuario no tenga una suscripción activa
        $userId = $request->validated()['user_id'];
        $existingSubscription = Subscription::where('user_id', $userId)->first();
    
        // Si el usuario ya tiene una suscripción activa, retornar un error
        if ($existingSubscription) {
            return response()->json([
                'message' => 'Este usuario ya tiene una suscripción activa.'
            ], 403); 
        }

        DB::beginTransaction();

        try {
            // Crear una nueva Subscription
            $validatedData = $request->validated();
            $subscription = Subscription::create($validatedData);
            
            // Actualizar la fecha de renovación
            $subscription->renewal_date = Carbon::now()->addMonth()->toDateString();
            $subscription->save();
            
            // Actualizar el tipo de usuario
            $user = User::find($validatedData['user_id']);
            if ($user) {
                $user->update(['user_type' => 'premium']);
            }

            //Creamos el método de pago
            $payment = Payment::create([
                'subscription_id' => $subscription->id,
                'payment_method' => $validatedData['payment_method'],
                'payment_date' => $validatedData['payment_date'],
                'total' => $validatedData['total'],
            ]);

            //Creamos el método de pago
            if ($validatedData['payment_method'] === 'paypal') {
                $paypalAccount = PaypalAccount::create([
                    'subscription_id' => $subscription->id,
                    'paypal_username' => $validatedData['paypal_username']
                ]);
            }else{
                $creditCard = CreditCard::create([
                    'subscription_id' => $subscription->id,
                    'card_number' => $validatedData['card_number'],
                    'expiry_month' => $validatedData['expiry_month'],
                    'expiry_year' => $validatedData['expiry_year'],
                    'security_code' => $validatedData['security_code'],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Suscripción creada con éxito',
                'data' => $subscription
            ], 201);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la suscripción',
                'data' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $subscription = Subscription::find($id);
        if ($subscription) {
            $user = $subscription->user;
            $payment = $subscription->payments;
            return response()->json([
                'message' => 'Suscripción encontrada',
                'data' => $subscription
            ], 200);
        } else {
            return response()->json([
                'message' => 'Suscripción no encontrada'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
