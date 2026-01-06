<?php

class User
{
    private $firstName;
    private $lastName;
    private $email;
    private $password;

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function emailExists($conn)
    {
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $check->bindValue(":email", $this->email);
        $check->execute();

        $existingUser = $check->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            return true;
        }
        return false;
    }
}
