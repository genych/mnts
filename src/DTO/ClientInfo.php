<?php declare(strict_types=1);

namespace App\DTO;

class ClientInfo
{
    private string $name;
    private string $surname;
    private string $country;

    /**
     * @param string $name
     * @param string $surname
     * @param string $country
     */
    public function __construct(string $name, string $surname, string $country)
    {
        $this->name    = $name;
        $this->surname = $surname;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

}
