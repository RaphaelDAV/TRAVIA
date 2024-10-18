<?php

class Planet {
    private int $id_planet;
    private string $image;
    private string $name;
    private string $coord;
    private int $x;
    private int $y;
    private string $subgridcood;
    private string $subgridx;
    private string $subgridy;
    private int $suns;
    private int $moons;
    private int $planet_position;
    private string $distance;
    private string $lengthday;
    private string $lengthyear;
    private string $diameter;
    private string $gravity;
    private int $id_region;
    private int $id_sector;

    public function __construct(array $data) {
        $this->id_planet = $data['Id'] ?? 0;
        $this->image = $data['Image'] ?? '';
        $this->name = $data['Name'] ?? '';
        $this->coord = $data['Coord'] ?? '';
        $this->x = $data['X'] ?? 0;
        $this->y = $data['Y'] ?? 0;
        $this->subgridcood = $data['SubGridCoord'] ?? '';
        $this->subgridx = $data['SubGridX'] ?? '';
        $this->subgridy = $data['SubGridY'] ?? '';
        $this->suns = $data['Suns'] ?? 0;
        $this->moons = $data['Moons'] ?? 0;
        $this->planet_position = $data['Position'] ?? 0;
        $this->distance = $data['Distance'] ?? '';
        $this->lengthday = $data['LengthDay'] ?? '';
        $this->lengthyear = $data['LengthYear'] ?? '';
        $this->diameter = $data['Diameter'] ?? '';
        $this->gravity = $data['Gravity'] ?? '';
        $this->id_region = 0;
        $this->id_sector = 0;
    }

    public function getIdPlanet(): int
    {
        return $this->id_planet;
    }

    public function setIdPlanet(int $id_planet): void
    {
        $this->id_planet = $id_planet;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCoord(): string
    {
        return $this->coord;
    }

    public function setCoord(string $coord): void
    {
        $this->coord = $coord;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function getSubgridcood(): string
    {
        return $this->subgridcood;
    }

    public function setSubgridcood(string $subgridcood): void
    {
        $this->subgridcood = $subgridcood;
    }

    public function getSubgridx(): string
    {
        return $this->subgridx;
    }

    public function setSubgridx(string $subgridx): void
    {
        $this->subgridx = $subgridx;
    }

    public function getSubgridy(): string
    {
        return $this->subgridy;
    }

    public function setSubgridy(string $subgridy): void
    {
        $this->subgridy = $subgridy;
    }

    public function getSuns(): int
    {
        return $this->suns;
    }

    public function setSuns(int $suns): void
    {
        $this->suns = $suns;
    }

    public function getMoons(): int
    {
        return $this->moons;
    }

    public function setMoons(int $moons): void
    {
        $this->moons = $moons;
    }

    public function getPlanetPosition(): int
    {
        return $this->planet_position;
    }

    public function setPlanetPosition(int $planet_position): void
    {
        $this->planet_position = $planet_position;
    }

    public function getDistance(): string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): void
    {
        $this->distance = $distance;
    }

    public function getLengthday(): string
    {
        return $this->lengthday;
    }

    public function setLengthday(string $lengthday): void
    {
        $this->lengthday = $lengthday;
    }

    public function getLengthyear(): string
    {
        return $this->lengthyear;
    }

    public function setLengthyear(string $lengthyear): void
    {
        $this->lengthyear = $lengthyear;
    }

    public function getDiameter(): string
    {
        return $this->diameter;
    }

    public function setDiameter(string $diameter): void
    {
        $this->diameter = $diameter;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function setGravity(string $gravity): void
    {
        $this->gravity = $gravity;
    }

    public function getIdRegion(): int
    {
        return $this->id_region;
    }

    public function setIdRegion(int $id_region): void
    {
        $this->id_region = $id_region;
    }

    public function getIdSector(): int
    {
        return $this->id_sector;
    }

    public function setIdSector(int $id_sector): void
    {
        $this->id_sector = $id_sector;
    }


    public function insertPlanet($conn, int $id_region, int $id_sector) {
        $stmt = $conn->prepare("
        INSERT INTO travia_planet 
        (id_planet, image, name, coord, x, y, subgridcood, subgridx, subgridy, suns, moons, planet_position, distance, lengthday, lengthyear, diameter, gravity, id_region, id_sector)  
        VALUES (:id, :image, :name, :coord, :x, :y, :subgridcood, :subgridx, :subgridy, :suns, :moons, :planet_position, :distance, :lengthday, :lengthyear, :diameter, :gravity, :id_region, :id_sector)
    ");

        $stmt->bindParam(':id', $this->id_planet, PDO::PARAM_INT);
        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':coord', $this->coord, PDO::PARAM_STR);
        $stmt->bindParam(':x', $this->x, PDO::PARAM_INT);
        $stmt->bindParam(':y', $this->y, PDO::PARAM_INT);
        $stmt->bindParam(':subgridcood', $this->subgridcood, PDO::PARAM_STR);
        $stmt->bindParam(':subgridx', $this->subgridx, PDO::PARAM_STR);
        $stmt->bindParam(':subgridy', $this->subgridy, PDO::PARAM_STR);
        $stmt->bindParam(':suns', $this->suns, PDO::PARAM_INT);
        $stmt->bindParam(':moons', $this->moons, PDO::PARAM_INT);
        $stmt->bindParam(':planet_position', $this->planet_position, PDO::PARAM_INT);
        $stmt->bindParam(':distance', $this->distance, PDO::PARAM_STR);
        $stmt->bindParam(':lengthday', $this->lengthday, PDO::PARAM_STR);
        $stmt->bindParam(':lengthyear', $this->lengthyear, PDO::PARAM_STR);
        $stmt->bindParam(':diameter', $this->diameter, PDO::PARAM_STR);
        $stmt->bindParam(':gravity', $this->gravity, PDO::PARAM_STR);
        $stmt->bindParam(':id_region', $id_region, PDO::PARAM_INT);
        $stmt->bindParam(':id_sector', $id_sector, PDO::PARAM_INT);

        $stmt->execute();

        return $conn->lastInsertId();
    }

}
?>
