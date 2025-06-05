<?php
namespace App\Controllers;

use App\Models\Task;

class TaskController
{
    private $model;

    public function __construct()
    {
        $this->model = new Task();
    }

    public function index()
    {
        echo json_encode($this->model->all());
    }

    public function show($params)
    {
        $id = $params['id'] ?? null;
        if ($id === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id']);
            return;
        }
        $task = $this->model->find($id);
        if ($task) {
            echo json_encode($task);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || !isset($data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            return;
        }
        $task = $this->model->create($data['title']);
        http_response_code(201);
        echo json_encode($task);
    }

    public function update($params)
    {
        $id = $params['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        if ($id === null || !$data || !isset($data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data']);
            return;
        }
        $task = $this->model->update($id, $data['title']);
        if ($task) {
            echo json_encode($task);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
        }
    }

    public function destroy($params)
    {
        $id = $params['id'] ?? null;
        if ($id === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id']);
            return;
        }
        $deleted = $this->model->delete($id);
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
        }
    }
}
