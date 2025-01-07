<?php

namespace Flow\Id\Controller\Profile;

use Flow\Id\Controller\Base;

class General extends Base
{
    /**
     * @param positive-int $userId
     * @return array{fNameEncrypted:non-empty-string,lNameEncrypted:non-empty-string,bDayEncrypted:non-empty-string}
     */
    public function getBasicInfo(int $userId): array
    {
        $info = $this->storage->getBasicInfo($userId);

        return $info;
    }
}
