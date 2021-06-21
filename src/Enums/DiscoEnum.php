<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-clubkonnect
 * Company: Stimolive Technologies Limited
 * Class Name: NetworkEnum.php
 * Date Created: 5/14/21
 * Time Created: 10:47 AM
 */

namespace HenryEjemuta\LaravelClubKonnect\Enums;


use HenryEjemuta\LaravelClubKonnect\Exceptions\ClubKonnectErrorException;

class DiscoEnum
{
    private static $cache = [];
    private static $discos = [
        'ekedc' => ['code' => '01', 'name' => 'Eko Electric - EKEDC'],
        'ikedc' => ['code' => '02', 'name' => 'Ikeja Electric - IKEDC'],
        'aedc' => ['code' => '03', 'name' => 'Abuja Electric - AEDC'],
        'kedc' => ['code' => '04', 'name' => 'Kano Electric - KEDC'],
        'phedc' => ['code' => '05', 'name' => 'Porthacourt Electric - PHEDC'],
        'jedc' => ['code' => '06', 'name' => 'Jos Electric - JEDC'],
        'ibedc' => ['code' => '07', 'name' => 'Ibadan Electric - IBEDC'],
        'kaedc' => ['code' => '08', 'name' => 'Kaduna Elecdtric - KAEDC'],
        'eedc' => ['code' => '09', 'name' => 'Enugu Electric - EEDC'],
    ];

    private $disco;
    private $uid;

    private function __construct(string $uid, array $disco)
    {
        $this->uid = $uid;
        $this->disco = (object)$disco;
    }

    public function getUID(): string
    {
        return $this->disco->uid;
    }

    public function getCode(): string
    {
        return $this->disco->code;
    }

    public function getName(): string
    {
        return $this->disco->name;
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->getUID(),
            'code' => $this->getCode(),
            'name' => $this->getName()
        ];
    }

    /**
     * @param $uid
     * @return DiscoEnum|null
     * @throws ClubKonnectErrorException
     */
    public static function getByUID($uid): ?DiscoEnum
    {
        $uid = trim("$uid");
        if (!key_exists($uid, self::$discos))
            throw new ClubKonnectErrorException("Not a valid ClubKonnect Disco", 999);
        if (!key_exists($uid, self::$cache))
            self::$cache[$uid] = new DiscoEnum($uid, self::$discos[$uid]);
        return self::$cache[$uid];
    }

    /**
     * @param $code
     * @return DiscoEnum|null
     * @throws ClubKonnectErrorException
     */
    public static function getByCode($code): ?DiscoEnum
    {
        $code = trim($code);
        if (!key_exists($code, self::$cache)) {
            $found = false;
            foreach (self::$discos as $idx => $disco) {
                if ($disco['code'] == $code) {
                    self::$cache[$code] = new DiscoEnum($idx, $disco);
                    $found = true;
                }
            }
            if (!$found) {
                throw new ClubKonnectErrorException("Not a valid ClubKonnect Disco", 999);
            }
        }
        return self::$cache[$code];
    }

    public function __toString(): string
    {
        return print_r($this->toArray(), true);
    }
}
