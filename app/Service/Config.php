<?php

namespace FileSharing\Service;


use Symfony\Component\Yaml\Yaml;

class Config
{
    private $filePath = '';

    private $config = [];

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->config = $this->getFromFile();
    }

    public function userDefined()
    {
        return !empty($this->config['username']) && !empty($this->config['password']);
    }

    public function setUser(string $username, string $password)
    {
        $this->config['username'] = $username;
        $this->config['password'] = password_hash($password, PASSWORD_BCRYPT);

        $this->flush();
    }

    public function userValid(string $username, string $password) : bool
    {
        return $this->config['username'] === $username && password_verify($password, $this->config['password']);
    }

    public function isTokenValid(string $token)
    {
        return $this->config['token'] === $token;
    }

    private function flush()
    {
        $newConfig = Yaml::dump($this->config);
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