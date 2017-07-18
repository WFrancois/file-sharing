<?php

namespace FileSharing\Service;


use Symfony\Component\Yaml\Yaml;

class Config
{
    private $filePath = '';

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function userDefined()
    {
        $config = $this->getFromFile();


        return !empty($config['username']) && !empty($config['password']);
    }

    public function setUser(string $username, string $password)
    {
        $config = $this->getFromFile();

        $config['username'] = $username;
        $config['password'] = password_hash($password, PASSWORD_BCRYPT);

        $newConfig = Yaml::dump($config);
        file_put_contents($this->filePath, $newConfig);
    }

    private function getFromFile() : array
    {
        if(file_exists($this->filePath)) {
            $yaml = Yaml::parse(file_get_contents($this->filePath));

            if($yaml) {
                return $yaml;
            }
        }
        return [];
    }
}