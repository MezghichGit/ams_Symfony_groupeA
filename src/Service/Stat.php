<?php

namespace App\Service;
use App\Repository\ProviderRepository;
class Stat {

    private $providerRepository;

    public function __construct(ProviderRepository $providerRepository)
    {
       $this->providerRepository =  $providerRepository ;
    }

    public function nbProviders(): string
    {
        
       return $this->providerRepository->totalProviders();
    }
}