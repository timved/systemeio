<?php

declare(strict_types=1);

namespace App\Dto;

use App\Request\RequestResolverInterface;
use App\Request\SelfValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class TaxCountryRequestDto implements SelfValidatorInterface, RequestResolverInterface
{
    public const array COUNTRY_CODE_VALIDATE = [
        'DE' => '/(DE)[0-9]{9}/',
        'IT' => '/(IT)[0-9]{11}/',
        'GR' => '/(GR)[0-9]{9}/',
        'FR' => '/(FR)[A-Z]{2}[0-9]{9}/',
    ];

    protected ?string $countryCode;

    #[Assert\Length(min: 9, max: 11)]
    #[Assert\NotNull]
    protected ?string $taxNumber;

    public function __construct(Request $request)
    {
        $this->taxNumber = $request->getPayload()->get('taxNumber');
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function validate(): void
    {
        $code = substr($this->taxNumber, 0, 2);

        if (!isset(static::COUNTRY_CODE_VALIDATE[$code])
            || !preg_match(static::COUNTRY_CODE_VALIDATE[$code], $this->taxNumber)
        ) {
            throw new BadRequestHttpException('Invalid taxNumber');
        }

        $this->countryCode = $code;
    }
}
