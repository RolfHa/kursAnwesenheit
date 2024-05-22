<?php



class Anwesenheit
{
    private int $id;
    private int $dozenten_id;
    private int $teilnehmer_id;

    private DateTime $datum;
    private string $status;

    /**
     * @param int $id
     * @param int $dozenten_id
     * @param int $teilnehmer_id
     * @param DateTime $datum
     * @param string $status
     */
    public function __construct(int $id, int $dozenten_id, int $teilnehmer_id, string $datum_string, string $status)
    {
        $datum = new DateTime($datum_string);
        $this->id = $id;
        $this->dozenten_id = $dozenten_id;
        $this->teilnehmer_id = $teilnehmer_id;
        $this->datum = $datum;
        $this->status = $status;
    }

    public static function dbcon():PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "anwesenheit";
        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    }

    public static function create(int $dozenten_id, int $teilnehmer_id, string $datum, string $status):Anwesenheit
    {
        $con = self::dbcon();
        $sql = "INSERT INTO anwesenheit (dozenten_id, teilnehmer_id, datum, status) VALUES (:dozenten_id, :teilnehmer_id, :datum, :status)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':dozenten_id'=>$dozenten_id, ':teilnehmer_id'=>$teilnehmer_id, ':datum'=>$datum, ':status'=>$status]);
        return self::findById($con->lastInsertId());


    }

    public static function findById(int $id):Anwesenheit
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM anwesenheit where id=:id';
        $stmt = $con->prepare($sql);
        $stmt->execute([':id'=>$id]);
        $result = $stmt->fetch(2);
        return new Anwesenheit($result["id"],$result['dozenten_id'],$result['teilnehmer_id'],$result['datum'],$result['status']);
    }

    /**
     * @param int $id
     * @return Anwesenheit[]
     */
    public static function findByTeilId(int $id)
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM anwesenheit where teilnehmer_id=:id';
        $stmt = $con->prepare($sql);
        $stmt->execute([':id'=>$id]);
        $results = $stmt->fetchAll(2);
        $anwesen = [];
        foreach ($results as $result) {
            $anwesen[]= new Anwesenheit($result["id"],$result['dozenten_id'],$result['teilnehmer_id'],$result['datum'],$result['status']);

        }
        return $anwesen;
    }

    /**
     * @param int $id
     * @param int $month
     * @return Anwesenheit[]

     */
    public static function findByMonthTId(int $id, int $month)
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM anwesenheit where teilnehmer_id=:id and month(datum) = :month';
        $stmt = $con->prepare($sql);
        $stmt->execute([':id'=>$id,':month'=>$month]);
        $results = $stmt->fetchAll(2);
        $anwesen = [];
        foreach ($results as $result) {
            $anwesen[]= new Anwesenheit($result["id"],$result['dozenten_id'],$result['teilnehmer_id'],$result['datum'],$result['status']);

        }
        return $anwesen;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDatum():string
    {
        return $this->datum->format('d:m:y');
    }

    public function getDatumObj()
    {
        return $this->datum;
    }






}