<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\CartCheckoutRequest;
use App\Mail\OrderShippedMail;
use DateInterval;
use Domain\Orders\Actions\CreateOrderAction;
use Domain\Orders\DTOs\CreateOrderParamsDTO;
use Domain\Orders\DTOs\OrderProductItemDTO;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\BaseUser\BaseUser;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Support\H;

class CartCheckoutController extends BaseWebController
{
    public function __invoke(CartCheckoutRequest $request)
    {
        $authUser = H::userOrAdmin();

        $order = $this->createOrder($request, $authUser);

        if ($order === null) {
            return redirect()->route("cart.show")->with('cart-error', "Что-то пошло не так. Попробуйте, пожалуйста, ещё раз.");
        }

        $userWithEmailExists = BaseUser::query()->where("email", $request->email)->exists();

        if ($authUser->is_identified) {
            $email = $authUser->email;
            $password = null;
        } elseif ($userWithEmailExists) {
            $email = $request->email;
            $password = null;
        } else {
            $email = $request->email;
            $authUser->email = $request->email;
            $authUser->name = $request->name;
            $authUser->phone = $request->phone;
            $password = H::random_str(6);
            $authUser->password = Hash::make($password);
            $authUser->save();
        }

        Mail::later(
            new DateInterval('PT10S'),
            new OrderShippedMail(
                $order,
                $authUser->id,
                $email,
                $password
            )
        );

        try {
            $authUser->cart()->detach();
        } catch (Exception $ignored) {
        }

        return redirect()->route("cart.success", $order->id);
    }

    protected function createOrder(CartCheckoutRequest $request, BaseUser $user): ?Order
    {
        $createOrderAction = resolve(CreateOrderAction::class);

        $productItems = [];
        $user->cart_not_trashed->each(function (Product $product) use (&$productItems) {
            $productItems[] = new OrderProductItemDTO([
                'count' => $product->cart_product->count ?? 1,
                'product' => $product,
            ]);
        });

        return $createOrderAction->execute(new CreateOrderParamsDTO([
            'user' => $user,
            'order_status_id' => OrderStatus::ID_OPEN,
            'importance_id' => OrderImportance::ID_GREY,
            'order_event_type' => OrderEventType::checkout(),
            'comment_user' => $request->comment,
            'request_name' => $request->name,
            'request_email' => $request->email,
            'request_phone' => $request->phone,
            'productItems' => $productItems,
            'attachment' => $request->attachment ?? [],
        ]));
    }
}
