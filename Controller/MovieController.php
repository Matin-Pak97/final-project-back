<?php

namespace CRUD\Controller;

use CRUD\Helper\MovieHelper;
use CRUD\Model\Actions;
use CRUD\Model\Movie;
use function Sodium\add;

class MovieController
{
    public function switcher($method, $request)
    {
        switch ($method) {
            case Actions::CREATE:
                $this->createAction($request);
                break;
            case Actions::UPDATE:
                $this->updateAction($request);
                break;
            case Actions::READ_ALL:
                if($_REQUEST['id']) {
                    $this->readAction($_REQUEST);
                } else if ($_REQUEST['filter']) {
                    $this->readFilteredAction($_REQUEST);
                } else {
                    $this->readAllAction($_REQUEST);
                }
                break;
            case Actions::DELETE:
                $this->deleteAction($_REQUEST);
                break;
            default:
                break;
        }
    }

    public function createAction($request)
    {
        $movie = new Movie();
        $movie->setTitle($request->title);
        $movie->setImage($request->image);
        $movie->setYear($request->year);
        $movie->setDescription($request->description);
        $movieHelper = new MovieHelper();
        if($movieHelper->insert($movie)) {
            http_response_code(200);
        } else {
            http_response_code(401);
        }
    }

    public function updateAction($request)
    {
        $movie = new Movie();
        $movie->setId($request->id);
        $movie->setTitle($request->title);
        $movie->setImage($request->image);
        $movie->setYear($request->year);
        $movie->setDescription($request->description);
        $movieHelper = new MovieHelper();
        if($movieHelper->update($movie)) {
            http_response_code(200);
        } else {
            http_response_code(401);
        }
    }

    public function readAction($request)
    {
        $movieHelper = new MovieHelper();
        $movie = $movieHelper->fetchById($request['id']);
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($movie);
    }

    public function readFilteredAction($request)
    {
        $movieHelper = new MovieHelper();
        $movies = $movieHelper->fetchByTitleOrYear($request['filter']);
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($movies);
    }

    public function readAllAction($request)
    {
        $movieHelper = new MovieHelper();
        $movies = $movieHelper->fetchAll();
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($movies);
    }

    public function deleteAction($request)
    {
        $movieHelper = new MovieHelper();
        if($movieHelper->delete($request['id'])) {;
            http_response_code(200);
        } else {
            http_response_code(401);
        }
    }
}