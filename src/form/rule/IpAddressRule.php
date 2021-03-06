<?php

namespace sndsgd\form\rule;

/**
 * Ensure a value is a valid ip address, optionally with a valid port
 */
class IpAddressRule extends RuleAbstract
{
    /**
     * Whether a port is required
     *
     * @var bool
     */
    protected $requirePort;

    /**
     * @param bool $requirePort Whether a port is required
     */
    public function __construct(bool $requirePort = false)
    {
        $this->requirePort = $requirePort;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return ($this->requirePort) ? _("ip:port") : _("ip");
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }

        if ($this->requirePort) {
            return _("must be a valid ip address and port combination");
        }

        return _("must be a valid ip address");
    }

    /**
     * @inheritDoc
     */
    public function validate(
        &$value,
        \sndsgd\form\Validator $validator = null
    ): bool
    {
        list($ip, $port) = array_pad(explode(":", $value), 2, null);

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        if (!$this->requirePort && $port === null) {
            return true;
        }

        $intPort = intval($port);
        return ($port == $intPort && $intPort > 0 && $intPort <= 65535);
    }
}
