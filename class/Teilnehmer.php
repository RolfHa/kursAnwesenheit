<?php

class Teilnehmer extends User
{
    private int $t_id;
    private string $fachrichtung;
    private string $team;

    /**
     * @param int $id
     * @param string $fname
     * @param string $lanme
     * @param string $pwhash
     * @param string $email
     * @param string $role
     * @param int $t_id
     * @param string $fachrichtung
     * @param string $team
     */
    public function __construct(int $id, string $fname, string $lanme, string $pwhash, string $email, string $role, int $t_id, string $fachrichtung, string $team)
    {
        parent::__construct($id, $fname, $lanme, $pwhash, $email, $role);
        $this->t_id = $t_id;
        $this->fachrichtung = $fachrichtung;
        $this->team = $team;
    }

    public static function createteilnehmer(string $fname, string $lname, string $password, string $email, string $role, string $fachrichtung, string $team): Teilnehmer
    {
        $user = User::create($fname, $lname, $password, $email, $role);
        $con = parent::dbcon();
        $sql = 'INSERT INTO teilnehmer ( user_id, fachrichtung, team) values (:userid, :fachrichtung, :team) ';
        $stmt = $con->prepare($sql);
        $user_id = $user->getId();
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':fachrichtung', $fachrichtung);
        $stmt->bindParam(':team', $team);
        $stmt->execute();
        return self::findTeilById($con->lastInsertId());

    }

    public static function findTeilById(int $id): Teilnehmer
    {
        $con = parent::dbcon();
        $sql = 'SELECT u.fname, u.lname, u.email,u.pwhash, u.role, t.fachrichtung, t.team, t.user_id, t.id
                FROM user u 
                join teilnehmer t on u.id = t.user_id
                where t.id =:id';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(2);
        return new Teilnehmer($result['user_id'], $result['fname'], $result['lname'], $result['pwhash'], $result['email'], $result['role'], $result['id'], $result['fachrichtung'], $result['role']);
    }

    /**
     * @return Teilnehmer[]
     */

    public static function findAll(): array
    {
        $con = parent::dbcon();
        $sql = 'SELECT id FROM teilnehmer';
        $stmt = $con->prepare($sql);
//        $stmt->bindParam(':teilnehmer', $teilnehmer);
        $stmt->execute();
        $results = $stmt->fetchAll(2);
        $teilnehmer = [];
        foreach ($results as $result) {
            $teilnehmer[] = self::findTeilById($result['id']);
        }
        return $teilnehmer;
    }


}