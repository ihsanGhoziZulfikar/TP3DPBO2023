<?php

class Person extends DB
{
    function getPersonJoin()
    {
        $query = "SELECT person.id, person.name, person.age, person.photo, person.race_id, person.religion_id, race.name as race_name, religion.name as religion_name FROM person JOIN race ON person.race_id=race.id JOIN religion ON person.religion_id=religion.id ORDER BY person.name";

        return $this->execute($query);
    }
    
    function getPersonJoinDesc()
    {
        $query = "SELECT person.id, person.name, person.age, person.photo, person.race_id, person.religion_id, race.name as race_name, religion.name as religion_name FROM person JOIN race ON person.race_id=race.id JOIN religion ON person.religion_id=religion.id ORDER BY person.name DESC";

        return $this->execute($query);
    }

    function getPerson()
    {
        $query = "SELECT * FROM person";
        return $this->execute($query);
    }

    function getPersonById($id)
    {
        $query = "SELECT  person.id, person.name, person.age, person.photo, person.race_id, person.religion_id, race.name as race_name, religion.name as religion_name  FROM person JOIN race ON person.race_id=race.id JOIN religion ON person.religion_id=religion.id WHERE person.id=$id";
        return $this->execute($query);
    }

    function searchPerson($keyword)
    {
        $query = "SELECT  person.id, person.name, person.age, person.photo, person.race_id, person.religion_id, race.name as race_name, religion.name as religion_name  FROM person JOIN race ON person.race_id=race.id JOIN religion ON person.religion_id=religion.id WHERE person.name LIKE '%$keyword%'  OR race.name LIKE '%$keyword%' OR religion.name LIKE '%$keyword%' ORDER BY person.name";
        return $this->execute($query);
    }

    function searchPersonDesc($keyword)
    {
        $query = "SELECT  person.id, person.name, person.age, person.photo, person.race_id, person.religion_id, race.name as race_name, religion.name as religion_name  FROM person JOIN race ON person.race_id=race.id JOIN religion ON person.religion_id=religion.id WHERE person.name LIKE '%$keyword%'  OR race.name LIKE '%$keyword%' OR religion.name LIKE '%$keyword%' ORDER BY person.name DESC";
        return $this->execute($query);
    }

    function addPerson($data, $file)
    {
        $photoName = $file['photo']['name'];
        $photoNameTmp = $file['photo']['tmp_name'];
        $destination = 'assets/images/' . $photoName;

        if(!move_uploaded_file($photoNameTmp, $destination)){
            $photoName = 'noPhoto.png';
        }

        $name = $data['name'];
        $age = $data['age'];
        $raceId = $data['raceId'];
        $religionId = $data['religionId'];
        $query = "INSERT INTO person(name, age, photo, race_id, religion_id) VALUES('$name', '$age', '$photoName', '$raceId', '$religionId')";
        return $this->executeAffected($query);
    }

    function updatePerson($id, $data, $file)
    {
        $photoName = $file['photo']['name'];
        $photoNameTmp = $file['photo']['tmp_name'];
        $destination = 'assets/images/' . $photoName;

        if(!move_uploaded_file($photoNameTmp, $destination)){
            $photoName = $data['prevPhoto'];
        }

        $name = $data['name'];
        $age = $data['age'];
        $raceId = $data['raceId'];
        $religionId = $data['religionId'];
        $query = "UPDATE person SET name='$name', age='$age', photo='$photoName', race_id='$raceId', religion_id='$religionId' WHERE id=$id";
        return $this->executeAffected($query);
    }

    function deletePerson($id)
    {
        $query = "DELETE FROM person WHERE id = $id";
        return $this->executeAffected($query);
    }
}
