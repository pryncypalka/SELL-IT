<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class DogsRepository extends Repository
{    
    public function getDogs(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM dogs;
        ');
        $stmt->execute();
        $dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

         foreach ($dogs as $dog) {
             $result[] = new Dog(
                 $dog['name'],
                 $dog['breed'],
                 $dog['description'],
                 $dog['color'],
                 $dog['photoUrl'],
             );
         }

        return $result;
    }
}
