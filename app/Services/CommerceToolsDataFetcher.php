<?php

namespace App\Services;

class CommerceToolsDataFetcher
{
    private CommerceToolsService $commerceToolsService;

    public function __construct(CommerceToolsService $commerceToolsService)
    {
        $this->commerceToolsService = $commerceToolsService;
    }

    public function fetchAllOrders($queryArgs): array
    {
        $batchSize = 100;
        $allOrders = [];
        $offset = 0;

        $apiClient = $this->commerceToolsService->createApiClient();
        $initialOrderBatch = $apiClient->orders()->get()->withWhere($queryArgs)->withOffset(0)->withLimit($batchSize)->withSort('createdAt desc')->execute();
        $totalOrders = $initialOrderBatch->getTotal();

        $allOrders = array_merge($allOrders, $initialOrderBatch->getResults()->toArray());
        $offset += $initialOrderBatch->getCount();
        $remainingOrders = $totalOrders - count($allOrders);
        $batchCount = ceil($remainingOrders / $batchSize);

        for ($i = 0; $i < $batchCount; $i++) {
            $batchOffset = $offset + $i * $batchSize;
            $batch = $apiClient->orders()->get()->withWhere($queryArgs)->withOffset($batchOffset)->withLimit($batchSize)->withSort('createdAt desc')->execute();
            $allOrders = array_merge($allOrders, $batch->getResults()->toArray());
        }

        return $allOrders;
    }

    public function getCurrentOrderCount($queryArgs): string
    {
        return $this->fetchCurrentOrders($queryArgs)->getTotal();
    }

    public function fetchCurrentOrders($queryArgs)
    {
        $apiClient = $this->commerceToolsService->createApiClient();

        return $apiClient->orders()->get()->withWhere($queryArgs)->withSort('createdAt desc')->execute();
    }

    public function fetchCurrentCustomers($queryArgs)
    {
        $apiClient = $this->commerceToolsService->createApiClient();

        return $apiClient->customers()->get()->withWhere($queryArgs)->withSort('createdAt desc')->execute();
    }

    public function getCurrentCustomerCount($queryArgs): string
    {
        return $this->fetchCurrentCustomers($queryArgs)->getTotal();
    }
}
