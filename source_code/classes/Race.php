<?php

class Race extends DB
{
    function getRace()
    {
        $query = "SELECT * FROM race ORDER BY name";
        return $this->execute($query);
    }
    
    function getRaceDesc()
    {
        $query = "SELECT * FROM race ORDER BY name DESC";
        return $this->execute($query);
    }

    function getRaceById($id)
    {
        $query = "SELECT * FROM race WHERE id=$id";
        return $this->execute($query);
    }

    function addRace($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO race VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateRace($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE race SET name = '$name' WHERE id = $id";
        return $this->executeAffected($query);
    }

    function deleteRace($id)
    {
        $query = "UPDATE person SET race_id=1 WHERE race_id = $id";
        $this->execute($query);
        $query = "DELETE FROM race WHERE id = $id";
        return $this->executeAffected($query);
    }

    function searchRace($keyword)
    {
        $query = "SELECT * FROM race  WHERE name LIKE '%$keyword%' ORDER BY name";
        return $this->execute($query);
    }

    function searchRaceDesc($keyword)
    {
        $query = "SELECT * FROM race  WHERE name LIKE '%$keyword%' ORDER BY name DESC";
        return $this->execute($query);
    }
}
