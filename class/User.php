<?php

class User
{
    private int $id;
    private string $fname;
    private string $lname;
    private string $pwhash;
    private string $email;
    private string $role;

    /**
     * @param int $id
     * @param string $fname
     * @param string $lanme
     * @param string $pwhash
     * @param string $email
     * @param string $role
     */
    public function __construct(int $id, string $fname, string $lname, string $pwhash, string $email, string $role)
    {
        $this->id = $id;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->pwhash = $pwhash;
        $this->email = $email;
        $this->role = $role;
    }

    public static function dbcon():PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "anwesenheit";
        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    }

    public static function create(string $fname, string $lname, string $password, string $email, string $role):User
    {
        $con = self::dbcon();
        $sql = 'INSERT INTO user (fname, lname, email, pwhash, role) VALUES (:fname, :lname, :email, :pwhash, :role)';
        $stmt = $con->prepare($sql);
        $pwhash = password_hash($password,PASSWORD_DEFAULT);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwhash', $pwhash);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return self::findById($con->lastInsertId());

    }

    public static function findById(int $id):User
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM user where id=:id';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch(2);
        return new User($result['id'],$result['fname'],$result['lname'],$result['pwhash'],$result['email'],$result['role']);
    }

    public function test($id)
    {
        return $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFname(): string
    {
        return $this->fname;
    }

    /**
     * @return string
     */
    public function getLname(): string
    {
        return $this->lname;
    }


}