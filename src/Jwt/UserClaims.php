<?php

namespace ilDug\Jwt;

class UserClaims
{
    private $u;
    const basic_claims = array(
        'uid',
        'email',
        'authorizations'
    );

    function __construct($u)
    {
        if (null === $u || !isset($u))
            throw new \Exception("user not defined for JWT creation ", 500);

        $this->u = $u;
    }


    function claims($c = null)
    {
        $claims = (array) $this->u;

        if (is_null($c)) {
            /** se non viene passato nessun claim specifico , 
             * li restituisce tutti tranne quelli base */
            $list = array();
            foreach ($claims as $claim => $value) {
                if (in_array($claim, self::basic_claims))
                    continue;
                else  $claim_list[$claim] = $value;
            }
            return $list;
        } else {
            /** restituisce il claim specifico passato come argomento*/
            switch ($c) {
                case 'uid':
                    return $this->uid();
                    break;

                case 'email':
                    return $this->email();
                    break;

                case 'authorizations':
                    return $this->authorizations();
                    break;

                default:
                    if (null === $claims[$c] || !isset($claims[$c]))
                        throw new \Exception("claim not defined for JWT ", 500);

                    if (is_array($claims[$c])) return json_encode($claims[$c]);
                    else return $claims[$c];
                    break;
            }
        }
    }


    /**
     * identificativo Utente
     */
    public function uid(): string
    {
        if (null === $this->u->uid || !isset($this->u->uid))
            throw new \Exception("uid not defined for JWT ", 500);

        return $this->u->uid;
    }


    /**
     * email dell'utente
     */
    public function email(): string
    {
        if (null === $this->u->email || !isset($this->u->email))
            throw new \Exception("email not defined for JWT ", 500);

        return $this->u->email;
    }


    /**
     * array di autorizzazione
     */
    public function authorizations(): string
    {
        if (null === $this->u->authorizations || !isset($this->u->authorizations))
            throw new \Exception("authorizations not defined for JWT ", 500);

        return $this->u->authorizations;
    }
}
