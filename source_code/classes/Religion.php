<?php

class Religion extends DB
{
    function getReligion()
    {
        $query = "SELECT * FROM religion ORDER BY name";
        return $this->execute($query);
    }
    
    function getReligionDesc()
    {
        $query = "SELECT * FROM religion ORDER BY name DESC";
        return $this->execute($query);
    }

    function getReligionById($id)
    {
        $query = "SELECT * FROM religion WHERE id=$id";
        return $this->execute($query);
    }

    function addReligion($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO religion VALUES('','$name')";
        return $this->executeAffected($query);
    }

    function updateReligion($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE religion SET name = '$name' WHERE id = $id";
        return $this->executeAffected($query);
    }

    function deleteReligion($id)
    {
        $query = "UPDATE person SET religion_id=1 WHERE religion_id = $id";
        $this->execute($query);
        $query = "DELETE FROM religion WHERE id = $id";
        return $this->executeAffected($query);
    }

    function searchReligion($keyword)
    {
        $query = "SELECT * FROM religion  WHERE name LIKE '%$keyword%' ORDER BY name";
        return $this->execute($query);
    }

    function searchReligionDesc($keyword)
    {
        $query = "SELECT * FROM religion  WHERE name LIKE '%$keyword%' ORDER BY name desc";
        return $this->execute($query);
    }
}
