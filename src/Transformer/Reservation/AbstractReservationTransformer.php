<?php

declare(strict_types=1);

namespace App\Transformer\Reservation;

abstract class AbstractReservationTransformer implements ReservationTransformerInterface
{
    private array $dataToTransform;
    private array $transformedData;

    protected function getDataToTransform(): array
    {
        return $this->dataToTransform;
    }

    public function setDataToTransform(array $data): void
    {
        $this->dataToTransform = $data;
    }

    protected function setTransformedData(array $transformedData): void
    {
        $this->transformedData = $transformedData;
    }

    public function getTransformedData(): array
    {
        return $this->transformedData;
    }
}
