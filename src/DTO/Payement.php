<?php ;

namespace App\DTO;
use App\Entity\Address;

class Payement {
    public ?string $cardNumber;
    public ?string $cardName;
    public ?string $expirationDate;
    public ?string $cvc;
    public ?Address $address;
}





?>