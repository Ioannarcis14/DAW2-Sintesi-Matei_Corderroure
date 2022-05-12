<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class APIJwt extends BaseConfig
{
    /**
     * tokenSecret
     * Defines key to sign digitally the token JWT.
     * To generate in hex2bin use:
     *      php spark key:generate --show
     * To generate in base64 use:
     *      php spark key:generate --show --prefix base64
     *
     * You must store only the key, without algorithm prefix
     *
     * @var string
     ***********************************************************
     *
     * hash
     * Defines hash used to sign JWT token. The signing algorithm (alg field)
     *      Supported algorithms are 'ES384','ES256', 'HS256', 'HS384',
     *      'HS512', 'RS256', 'RS384', and 'RS512'
     *
     * @var string
     ***********************************************************
     *
     * authTimeout
     * Defines timeout for token JWT, exp field into token JWT
     *      Set null to disable timeout
     *
     * @var int
     ***********************************************************
     *
     * issuer
     * Issuer of the JWT
     *      Set null to ignore iss field from JWT token
     *
     * @var string
     ***********************************************************
     *
     * audience
     * Audience of the JWT
     *      Set null to ignore aud field from JWT token
     *
     * @var string
     ***********************************************************
     *
     * subject
     * Subject of the JWT
     *      Set null to ignore sub field from JWT token
     *
     * @var string
     ***********************************************************
     *
     * autoRenew
     * Renew automatically JWT token every request
     *
     * @var bool
     ***********************************************************
     *
     * oneTimeToken
     * JWT Token can be used only one time, toherwise is revoked
     *
     * @var bool
     ***********************************************************
     */
    public $policyName = "default"; // Defines default policy name, to use by Library/Filter     
    public $default = [
        'tokenSecret'  => '5beb74d7e00dec0549cd3f990f180ef4166f77cfe7377d3eaec5a2a181e7751c', //hex2bin.
        'hash'         => "HS256",
        'authTimeout'  => 30 * MINUTE,
        'issuer'       => "daw-company",
        'audience'     => "daw-company.user-db",
        'subject'      => "secure.jwt.v1.daw",
        'autoRenew'    => true,
        'oneTimeToken' => true,
        'renewTokenField' => 'refreshToken',
        'includePolicy' => true,
    ];

    public function __construct($policy = null)
    {
        parent::__construct();

        if ($policy != null)
            $this->policyName = $policy;
    }

    /**
     * Returns deafult configuration or configuration group 
     * 
     * @param  mixed $groupName Config groupname to get
     * @return object
     */
    public function config($policy = null)
    {
        if ($policy == null) $policy = $this->policyName;

        $props = get_object_vars($this);

        if (isset($props[$policy]) && is_array($props[$policy])) {
            $props[$policy]["policy"] = $policy;
            return (object) $props[$policy];
        } else {
            $props[$this->policyName]["policy"] = $this->policyName;
            return (object) $props[$this->policyName];
        }
    }
}
