<?php

namespace Hostinger;

use Hostinger\RecordType\A;
use Hostinger\RecordType\A6;
use Hostinger\RecordType\Aaaa;
use Hostinger\RecordType\Cname;
use Hostinger\RecordType\Mx;
use Hostinger\RecordType\Ns;
use Hostinger\RecordType\RecordType;
use Hostinger\RecordType\Txt;

class RecordTypeFactory
{
    public static $dnsTypes = [
        DNS_A     => A::class,
        DNS_A6    => A6::class,
        DNS_AAAA  => Aaaa::class,
        DNS_CNAME => Cname::class,
        DNS_MX    => Mx::class,
        DNS_NS    => Ns::class,
        DNS_TXT   => Txt::class,
    ];

    /**
     * @param int $dnsType
     * @return RecordType
     */
    public function make($dnsType)
    {
        $class = $this->convertDnsTypeToString($dnsType);
        if (!class_exists($class)) {
            return null;
        }

        $obj = new $class();
        if (!$obj instanceof RecordType) {
            return null;
        }

        return $obj;
    }

    /**
     * @param int $dnsType
     * @return string
     */
    public function convertDnsTypeToString($dnsType)
    {
        return self::$dnsTypes[$dnsType];
    }
}
