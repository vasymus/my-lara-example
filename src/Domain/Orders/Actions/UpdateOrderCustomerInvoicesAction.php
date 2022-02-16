<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Support\H;

class UpdateOrderCustomerInvoicesAction
{
    /**
     * @var \Domain\Orders\Actions\SaveOrderMediasAction
     */
    private SaveOrderMediasAction $saveOrderMediasAction;

    /**
     * @param \Domain\Orders\Actions\SaveOrderMediasAction $saveOrderMediasAction
     */
    public function __construct(SaveOrderMediasAction $saveOrderMediasAction)
    {
        $this->saveOrderMediasAction = $saveOrderMediasAction;
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return void
     */
    public function execute(UpdateOrderInvoicesParamsDTO $params): void
    {
        if (! $this->haveChanges($params)) {
            return;
        }

        $shouldSave = false;

        if ($this->propertyHasChanged($params, 'customer_bill_status_id')) {
            $params->order->customer_bill_status_id = $params->customer_bill_status_id;
            $shouldSave = true;
        }

        if ($this->propertyHasChanged($params, 'customer_bill_description')) {
            $params->order->customer_bill_description = $params->customer_bill_description;
            $shouldSave = true;
        }

        if ($this->propertyHasChanged($params, 'provider_bill_status_id')) {
            $params->order->provider_bill_status_id = $params->provider_bill_status_id;
            $shouldSave = true;
        }

        if ($this->propertyHasChanged($params, 'provider_bill_description')) {
            $params->order->provider_bill_description = $params->provider_bill_description;
            $shouldSave = true;
        }

        if ($shouldSave) {
            $params->order->save();
        }

        if ($this->customerInvoicesHaveChanges($params)) {
            $this->saveOrderMediasAction->execute($params->order, $params->customerInvoices, Order::MC_CUSTOMER_INVOICES);
            $this->createCustomerInvoicesOrderEvent($params);
        }
        if ($this->supplierInvoicesHaveChanges($params)) {
            $this->saveOrderMediasAction->execute($params->order, $params->supplierInvoices, Order::MC_SUPPLIER_INVOICES);
            $this->createSupplierInvoicesOrderEvent($params);
        }
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function haveChanges(UpdateOrderInvoicesParamsDTO $params): bool
    {
        return $this->customerInvoicesHaveChanges($params) || $this->supplierInvoicesHaveChanges($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function customerInvoicesHaveChanges(UpdateOrderInvoicesParamsDTO $params): bool
    {
        return $this->propertyHasChanged($params, 'customer_bill_status_id') ||
            $this->propertyHasChanged($params, 'customer_bill_description') ||
            $this->hasNewInvoices($params->customerInvoices) ||
            $this->hasDeletedCustomerInvoices($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function supplierInvoicesHaveChanges(UpdateOrderInvoicesParamsDTO $params): bool
    {
        return $this->propertyHasChanged($params, 'provider_bill_status_id') ||
            $this->propertyHasChanged($params, 'provider_bill_description') ||
            $this->hasNewInvoices($params->supplierInvoices) ||
            $this->hasDeletedSupplierInvoices($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return string
     */
    private function getCustomerInvoicesOrderEventDescription(UpdateOrderInvoicesParamsDTO $params): string
    {
        $orderEventDescription = '';

        if ($this->propertyHasChanged($params, 'customer_bill_status_id')) {
            $billStatus = BillStatus::query()->findOrFail($params->customer_bill_status_id);
            $orderEventDescription .= sprintf('Статус: `%s`. ', $billStatus->name);
        }

        if ($this->propertyHasChanged($params, 'customer_bill_description')) {
            $orderEventDescription .= sprintf('Комментарий: `%s`. ', $params->customer_bill_description);
        }

        $hasNewInvoices = $this->hasNewInvoices($params->customerInvoices);
        $hasDeletedInvoices = $this->hasDeletedCustomerInvoices($params);
        if ($hasNewInvoices || $hasDeletedInvoices) {
            $detailed = $hasNewInvoices && $hasDeletedInvoices
                ? 'добавил и удалил.'
                : (
                    $hasNewInvoices
                        ? 'добавил.'
                        : 'удалил'
                );
            $orderEventDescription .= sprintf('Файлы: %s', $detailed);
        }

        return $orderEventDescription;
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return string
     */
    private function getSupplierInvoicesOrderEventDescription(UpdateOrderInvoicesParamsDTO $params): string
    {
        $orderEventDescription = '';

        if ($this->propertyHasChanged($params, 'provider_bill_status_id')) {
            $billStatus = BillStatus::query()->findOrFail($params->provider_bill_status_id);
            $orderEventDescription .= sprintf('Статус: `%s`. ', $billStatus->name);
        }

        if ($this->propertyHasChanged($params, 'provider_bill_description')) {
            $orderEventDescription .= sprintf('Комментарий: `%s`. ', $params->provider_bill_description);
        }

        $hasNewInvoices = $this->hasNewInvoices($params->supplierInvoices);
        $hasDeletedInvoices = $this->hasDeletedSupplierInvoices($params);
        if ($hasNewInvoices || $hasDeletedInvoices) {
            $detailed = $hasNewInvoices && $hasDeletedInvoices
                ? 'добавил и удалил.'
                : (
                    $hasNewInvoices
                    ? 'добавил.'
                    : 'удалил'
                );
            $orderEventDescription .= sprintf('Файлы: %s', $detailed);
        }

        return $orderEventDescription;
    }

    /**
     * @param array[] $invoices @see {@link \Domain\Common\DTOs\FileDTO}
     *
     * @return bool
     */
    private function hasNewInvoices(array $invoices): bool
    {
        return collect($invoices)->isNotEmpty() && collect($invoices)->contains(fn (array $file) => $file['id'] === null);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasDeletedCustomerInvoices(UpdateOrderInvoicesParamsDTO $params): bool
    {
        return H::runtimeCache(sprintf('%s-%s-%s', static::class, 'customer-invoices', $params->order->id), function () use ($params) {
            $payloadInvoicesIds = collect($params->customerInvoices)->pluck('id')->filter()->values()->toArray();
            $currentInvoicesIds = $params->order->customer_invoices->pluck('id')->filter()->values()->toArray();

            return count($currentInvoicesIds) !== 0 && count($currentInvoicesIds) !== count($payloadInvoicesIds);
        });
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasDeletedSupplierInvoices(UpdateOrderInvoicesParamsDTO $params): bool
    {
        return H::runtimeCache(sprintf('%s-%s-%s', static::class, 'supplier-invoices', $params->order->id), function () use ($params) {
            $payloadInvoicesIds = collect($params->supplierInvoices)->pluck('id')->filter()->values()->toArray();
            $currentInvoicesIds = $params->order->supplier_invoices->pluck('id')->filter()->values()->toArray();

            return count($currentInvoicesIds) !== 0 && count($currentInvoicesIds) !== count($payloadInvoicesIds);
        });
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return void
     */
    private function createCustomerInvoicesOrderEvent(UpdateOrderInvoicesParamsDTO $params): void
    {
        $orderEventPayload = [
            'description' => $this->getCustomerInvoicesOrderEventDescription($params),
        ];

        if ($this->propertyHasChanged($params, 'customer_bill_status_id')) {
            $orderEventPayload['customer_bill_status_id'] = $params->customer_bill_status_id;
        }

        if ($this->propertyHasChanged($params, 'customer_bill_description')) {
            $orderEventPayload['customer_bill_description'] = $params->customer_bill_description;
        }

        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_customer_invoice();
        $orderEvent->payload = $orderEventPayload;
        $orderEvent->order()->associate($params->order);
        if ($params->user) {
            $orderEvent->user()->associate($params->user);
        }
        $orderEvent->save();
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     *
     * @return void
     */
    private function createSupplierInvoicesOrderEvent(UpdateOrderInvoicesParamsDTO $params): void
    {
        $orderEventPayload = [
            'description' => $this->getSupplierInvoicesOrderEventDescription($params),
        ];

        if ($this->propertyHasChanged($params, 'provider_bill_status_id')) {
            $orderEventPayload['provider_bill_status_id'] = $params->provider_bill_status_id;
        }

        if ($this->propertyHasChanged($params, 'provider_bill_description')) {
            $orderEventPayload['provider_bill_description'] = $params->provider_bill_description;
        }

        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_supplier_invoice();
        $orderEvent->payload = $orderEventPayload;
        $orderEvent->order()->associate($params->order);
        if ($params->user) {
            $orderEvent->user()->associate($params->user);
        }
        $orderEvent->save();
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO $params
     * @param string $propertyName
     *
     * @return bool
     */
    private function propertyHasChanged(UpdateOrderInvoicesParamsDTO $params, string $propertyName): bool
    {
        return H::runtimeCache(
            sprintf('%s-%s-%s', static::class, $params->order->id, $propertyName),
            (string)$params->order->getOriginal($propertyName) !== (string)$params->$propertyName
        );
    }
}
