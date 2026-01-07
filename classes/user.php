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

    public function findByEmail($conn)
    {
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $statement->bindValue(":email", $this->email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getPasswordHashById($conn, $id)
    {
        $statement = $conn->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($conn, $id, $newPassword)
    {
        $options = ["cost" => 13];
        $hash = password_hash($newPassword, PASSWORD_BCRYPT, $options);

        $update = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $update->bindValue(":password", $hash);
        $update->bindValue(":id", $id);
        $update->execute();
    }

    public function getCurrencyById($conn, $userId)
    {
        $stmt = $conn->prepare("SELECT currency FROM users WHERE id = :id LIMIT 1");
        $stmt->bindValue(":id", $userId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row["currency"] : 0;
    }

    public function deductCurrency($conn, $userId, $amount)
    {
        $stmt = $conn->prepare("UPDATE users SET currency = currency - :amount WHERE id = :id");
        $stmt->bindValue(":amount", (int)$amount, PDO::PARAM_INT);
        $stmt->bindValue(":id", (int)$userId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
