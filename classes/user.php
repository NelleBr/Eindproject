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

    public function register($conn)
    {
        $options = ['cost' => 13];
        $hash = password_hash($this->password, PASSWORD_BCRYPT, $options);

        $statement = $conn->prepare("
        INSERT INTO users (first_name, last_name, email, password, is_admin, currency)
        VALUES (:first_name, :last_name, :email, :password, :is_admin, :currency)
        ");

        $statement->bindValue(":first_name", $this->firstName);
        $statement->bindValue(":last_name", $this->lastName);
        $statement->bindValue(":email", $this->email);
        $statement->bindValue(":password", $hash);
        $statement->bindValue(":is_admin", 0);
        $statement->bindValue(":currency", 1000);

        $statement->execute();
    }
}
