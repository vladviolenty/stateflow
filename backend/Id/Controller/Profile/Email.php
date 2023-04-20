<?php

namespace Flow\Id\Controller\Profile;

use Flow\Core\Exceptions\DatabaseException;
use Flow\Core\Exceptions\NotfoundException;
use VladViolentiy\VivaFramework\Exceptions\ValidationException;
use Flow\Id\Controller\Base;
use VladViolentiy\VivaFramework\Validation;

class Email extends Base
{

    /**
     * @param positive-int $userId
     * @return list<array{id:int,email:string}>
     * @throws DatabaseException
     */
    public function getEmailList(int $userId):array{
        return $this->storage->getEmailList($userId);
    }

    /**
     * @param positive-int $userId
     * @param non-empty-string $emailEncrypted
     * @param non-empty-string $emailHash
     * @param bool $allowAuth
     * @return int
     */
    public function addNewEmail(int $userId, string $emailEncrypted, string $emailHash, bool $allowAuth):int{
        $id = $this->storage->insertNewEmail($userId,$emailEncrypted,$emailHash,$allowAuth);
        return $id;
    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @param string $emailEncrypted
     * @param string $emailHash
     * @param bool $allowAuth
     * @throws ValidationException
     */
    public function editItem(int $userId,int $itemId, string $emailEncrypted, string $emailHash, bool $allowAuth):void{
        Validation::id($itemId);
        if($emailHash==="" or $emailEncrypted==="") throw new ValidationException();

        $this->storage->editEmailItem($itemId,$userId,$emailEncrypted,$emailHash,$allowAuth);
    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @return array{emailEncrypted:string,allowAuth:bool}
     * @throws DatabaseException
     * @throws NotfoundException
     */
    public function getEmailItem(int $userId, int $itemId):array{
        Validation::id($itemId);


        $i = $this->storage->getEmailItem($userId,$itemId);
        if($i===null) throw new NotfoundException();
        $i['allowAuth'] = (bool)$i['allowAuth'];
        return $i;

    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @return void
     */
    public function deleteEmail(int $userId, int $itemId):void{
        Validation::id($itemId);
        $this->storage->deleteEmail($userId,$itemId);
    }
}