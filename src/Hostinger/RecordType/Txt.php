<?php

namespace Hostinger\RecordType;

class Txt implements RecordType
{
    /**
     * Example of dig output
     * dig +noall +answer TXT hostingermail.com
     * hostingermail.com.      3599    IN      TXT      "asdf"
     * @param array $lines
     * @return array<mixed>
     */
    public function transform(array $lines)
    {
        $output = [];

        foreach ($lines as $line) {
            $recordProp = explode("\t", str_replace(["\t\t", "\n" ], ["\t", ''], $line));

            if ($recordProp[3] != $this->getType()) {
                continue;
            }

            $output[] = [
                'host'   => trim($recordProp[0], '\.'),
                'ttl'    => $recordProp[1],
                'class'  => $recordProp[2],
                'type'   => $recordProp[3],
                'target' => trim($recordProp[4], '\.'),
            ];
        }
        return $output;
    }

    public function getType()
    {
        return 'TXT';
    }
}
