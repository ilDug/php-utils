<?php

namespace ilDug\Jwt;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token\Plain;
use Ramsey\Uuid\Uuid;

class Token
{
    const JWT_NAMESPACE = "4c4aa820-a37e-11eb-87e8-0242ac150002";
    /**
     * genera 
     */
    private static function jti($uid)
    {
        $now   = new \DateTimeImmutable();
        $jti = Uuid::uuid5(self::JWT_NAMESPACE, $uid . $now->getTimestamp());
        return $jti;
    }

    /**
     * Crea ub nuovo Lcobucci/Jtt
     */
    static function create(JWTConfig $baseConf, object $user): Plain
    {
        $now   = new \DateTimeImmutable();
        $configuration = $baseConf->generate();
        $u = new UserClaims($user);

        $builder = $configuration->builder()
            ->issuedBy($baseConf->ISS) // Configures the issuer (iss claim)
            ->permittedFor($baseConf->AUD) // Configures the audience (aud claim)
            ->identifiedBy(self::jti($u->uid())) // Configures the id (jti claim)
            ->issuedAt($now) // Configures the time that the token was issue (iat claim)
            ->canOnlyBeUsedAfter($now->modify('+5 seconds')) // Configures the time that the token can be used (nbf claim)
            ->expiresAt($now->modify($baseConf->duration)); // Configures the expiration time of the token (exp claim);


        $builder->withClaim('uid', $u->uid()) // Configures claims
            ->withClaim('email', $u->email())
        ->withClaim('authorizations', json_decode($u->authorizations()));
        // ->withHeader('foo', 'bar') // Configures a new header, called "foo"

        foreach ($u->claims() as $claim => $value) {
            $builder->withClaim($claim, $value);
        }

        $token =  $builder->getToken($configuration->signer(), $configuration->signingKey()); // Builds a new token

        return $token;
    }


    /**
     * elabora un JWT  e restituisceun Token Lcobucci
     */
    static function parse(JWTConfig $baseConf, string $jwt): Plain //\Lcobucci\JWT\Token
    {
        /** genera la configurazione */
        $config = $baseConf->generate();
        /** decodifica il jwt  */
        $token = $config->parser()->parse($jwt);
        /** vefifica il token  */
        $config->validator()->assert($token, ...$config->validationConstraints());

        return $token;
    }
}
