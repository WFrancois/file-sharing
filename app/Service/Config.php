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

    public function userValid(string $username, string $password): bool
    {
        return $this->config['username'] === $username && password_verify($password, $this->config['password']);
    }

    public function getToken(): string
    {
        return $this->config['token'] ?? '';
    }

    public function resetToken()
    {
        $token = Util::generateRandomString($length = 20, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$!%#@&');
        $this->config['token'] = $token;

        $this->flush();
    }

    public function isTokenValid(string $token)
    {
        return $this->getToken() === $token;
    }

    public function keepFileName(): bool
    {
        if (empty($this->config['keepFileName'])) {
            return false;
        }

        return (bool) $this->config['keepFileName'];
    }

    public function setKeepFileName(bool $val)
    {
        $this->config['keepFileName'] = $val;

        $this->flush();
    }

    private function flush()
    {
        $newConfig = Yaml::dump($this->config);
        file_put_contents($this->filePath, $newConfig);
    }

    private function getFromFile(): array
    {
        if (file_exists($this->filePath)) {
            $yaml = Yaml::parse(file_get_contents($this->filePath));

            if ($yaml) {
                return $yaml;
            }
        }
        return [];
    }
}