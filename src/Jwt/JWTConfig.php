<?php

namespace ilDug\Jwt;

use Lcobucci\Clock\FrozenClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;


class JWTConfig
{
    public $rsa_key_path;
    public $rsa_crt_path;
    public $AUD;
    public $ISS;
    public $duration;

    function __construct(
        $rsa_key_path,
        $rsa_crt_path,
        $AUD = "ilDug",
        $ISS = "ilDug",
        $duration = '+1 month'
    ) {
        $this->rsa_key_path = $rsa_key_path;
        $this->rsa_crt_path = $rsa_crt_path;
        $this->AUD = $AUD;
        $this->ISS = $ISS;
        $this->duration = $duration;
    }

    function generate(): Configuration
    {
        $now   = new \DateTimeImmutable();
        $clock = new FrozenClock($now);

        $config = Configuration::forAsymmetricSigner(
            new Sha256(), //Signer
            InMemory::file($this->rsa_key_path), // Private Key
            InMemory::file($this->rsa_crt_path), // Certificate
        );

        $config->setValidationConstraints(
            new IssuedBy($this->ISS),
            new PermittedFor($this->AUD),
            new SignedWith($config->signer(), $config->verificationKey()),
            new ValidAt($clock)
        );

        return $config;
    }
}
