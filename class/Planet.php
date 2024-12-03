<?php

class Planet {
    private $id_planet;
    private $image;
    private $name;
    private $coord;
    private $x;
    private $y;
    private $subgridcoord;
    private $subgridx;
    private $subgridy;
    private $suns;
    private $moons;
    private $planet_position;
    private $distance;
    private $lengthday;
    private $lengthyear;
    private $diameter;
    private $gravity;
    private $id_region;
    private $id_sector;
    private $id_sun;

    // Constructor to import
    /*public function __construct($data) {
        $this->id_planet = $data['Id'];
        $this->image = $data['Image'];
        $this->name = $data['Name'];
        $this->coord = $data['Coord'];
        $this->x = $data['X'];
        $this->y = $data['Y'];
        $this->subgridcoord = $data['SubGridCoord'];
        $this->subgridx = $data['SubGridX'];
        $this->subgridy = $data['SubGridY'];
        $this->suns = $data['Suns'];
        $this->moons = $data['Moons'];
        $this->planet_position = $data['Position'];
        $this->distance = $data['Distance'];
        $this->lengthday = $data['LengthDay'];
        $this->lengthyear = $data['LengthYear'];
        $this->diameter = $data['Diameter'];
        $this->gravity = $data['Gravity'];
        $this->id_region = $data['id_region'];
        $this->id_sector = $data['id_sector'];
        $this->id_sun = $data['id_sun'] ?? 0;
    }*/

    // Constructor to normal usage
    public function __construct($data) {
        $this->id_planet = $data['id_planet'] ?? 0;
        $this->image = $data['image'] ?? '';
        $this->name = $data['name'] ?? 'Unknown';
        $this->coord = $data['coord'] ?? '';
        $this->x = $data['x'] ?? 0;
        $this->y = $data['y'] ?? 0;
        $this->subgridcoord = $data['subgridcoord'] ?? '';
        $this->subgridx = $data['subgridx'] ?? '';
        $this->subgridy = $data['subgridy'] ?? '';
        $this->suns = $data['Suns'] ?? 0;
        $this->moons = $data['moons'] ?? 0;
        $this->planet_position = $data['planet_position'] ?? 0;
        $this->distance = $data['distance'] ?? '';
        $this->lengthday = $data['lengthday'] ?? '';
        $this->lengthyear = $data['lengthyear'] ?? '';
        $this->diameter = $data['diameter'] ?? '';
        $this->gravity = $data['gravity'] ?? '';
        $this->id_region = $data['id_region'] ?? 0;
        $this->id_sector = $data['id_sector'] ?? 0;
        $this->id_sun = $data['id_sun'] ?? 0;
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

    public function getSubgridcoord(): string
    {
        return $this->subgridcoord;
    }

    public function setSubgridcoord(string $subgridcoord): void
    {
        $this->subgridcoord = $subgridcoord;
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

    public function getIdSun(): int
    {
        return $this->id_sun;
    }

    public function setIdSun(mixed $id_sun): void
    {
        $this->id_sun = $id_sun;
    }





    public function insertPlanet($conn, int $id_region, int $id_sector, ?int $id_sun) {
        $stmt = $conn->prepare("
        INSERT INTO travia_planet 
        (id_planet, image, name, coord, x, y, subgridcoord, subgridx, subgridy, suns, moons, planet_position, distance, lengthday, lengthyear, diameter, gravity, id_region, id_sector, id_sun)  
        VALUES (:id, :image, :name, :coord, :x, :y, :subgridcoord, :subgridx, :subgridy, :suns, :moons, :planet_position, :distance, :lengthday, :lengthyear, :diameter, :gravity, :id_region, :id_sector, :id_sun)
    ");

        $stmt->bindParam(':id', $this->id_planet, PDO::PARAM_INT);
        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':coord', $this->coord, PDO::PARAM_STR);
        $stmt->bindParam(':x', $this->x, PDO::PARAM_INT);
        $stmt->bindParam(':y', $this->y, PDO::PARAM_INT);
        $stmt->bindParam(':subgridcoord', $this->subgridcoord, PDO::PARAM_STR);
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
        if ($id_sun === null) {
            $stmt->bindValue(':id_sun', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':id_sun', $id_sun, PDO::PARAM_INT);
        }


        $stmt->execute();

        return $conn->lastInsertId();
    }

    public function calculateDistance(Planet $otherPlanet): float {
        $dx = $this->x - $otherPlanet->getX();
        $dy = $this->y - $otherPlanet->getY();

        return sqrt(pow($dx, 2) + pow($dy, 2));
    }


}
?>