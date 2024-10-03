<?php

class Planet {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function insertPlanet($conn, $id_region, $id_sector) {
        $stmt = $conn->prepare("
            INSERT INTO travia_planet 
            (id_planet, name, coord, x, y, subgridcood, subgridx, subgridy, suns, moons, planet_position, distance, lengthday, lengthyear, diameter, gravity, id_region, id_sector)  
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
        ");


        $stmt->bind_param(
            "issddsddiiidddddii",
            $this->data['Id'],
            $this->data['Name'],
            $this->data['Coord'],
            $this->data['X'],
            $this->data['Y'],
            $this->data['SubGridCoord'],
            $this->data['SubGridX'],
            $this->data['SubGridY'],
            $this->data['Suns'],
            $this->data['Moons'],
            $this->data['Position'],
            $this->data['Distance'],
            $this->data['LengthDay'],
            $this->data['LengthYear'],
            $this->data['Diameter'],
            $this->data['Gravity'],
            $id_region,
            $id_sector
        );

        $stmt->execute();
        return $conn->insert_id;
    }
}
