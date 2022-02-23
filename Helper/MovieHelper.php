<?php

namespace CRUD\Helper;

use CRUD\Model\Movie;

class MovieHelper
{
    public function insert(Movie $movie)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "INSERT INTO movie (title, image, year, description) VALUES ('" . $movie->getTitle() . "', '" . $movie->getImage() . "', '" . $movie->getYear() . "', '" . $movie->getDescription() . "')";
        if ($dbHelper->execQuery($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function fetchById(int $id)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $result = $dbHelper->execQuery("SELECT * FROM movie WHERE id = " . $id . ";");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchByTitleOrYear(string $filter)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $result = $dbHelper->execQuery("SELECT * FROM movie WHERE title LIKE '%" . $filter . "%' OR year = '" . $filter . "' ORDER BY id");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchAll()
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $result = $dbHelper->execQuery("SELECT * FROM movie ORDER BY id");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update(Movie $movie)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "UPDATE movie SET title = '" . $movie->getTitle() . "', image = '" . $movie->getImage() . "', year = '" . $movie->getYear() . "', description = '" . $movie->getDescription() . "' WHERE id = '" . $movie->getId() . "'";
        if ($dbHelper->execQuery($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        /** @var DBConnector $dbHelper */
        $dbHelper = new DBConnector();
        $dbHelper->connect();
        $sql = "DELETE FROM movie WHERE id = '" . $id . "'";
        if ($dbHelper->execQuery($sql)) {
            return true;
        } else {
            return false;
        }
    }
}